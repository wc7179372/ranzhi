<?php
/**
 * The model file for contract of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class contractModel extends model
{
    /**
     * Get contract by ID.
     * 
     * @param  int    $contractID 
     * @access public
     * @return object.
     */
    public function getByID($contractID)
    {
        $contract = $this->dao->select('*')->from(TABLE_CONTRACT)->where('id')->eq($contractID)->fetch();
        if($contract)
        {
            $contract->order = array();
            $contractOrders = $this->dao->select('*')->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->fetchAll();
            foreach($contractOrders as $contractOrder) $contract->order[] = $contractOrder->order;

            $contract->files = $this->loadModel('file')->getByObject('contract', $contractID);
        }

        return $contract;
    }

    /**
     * Get contract list.
     * 
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getList($customer = 0, $orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_CONTRACT)
            ->where('deleted')->eq(0)
            ->beginIF($customer)->andWhere('customer')->eq($customer)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get contract pairs.
     * 
     * @access public
     * @return array
     */
    public function getPairs($customerID)
    {
        return $this->dao->select('id, name')->from(TABLE_CONTRACT)
            ->where('customer')->eq($customerID)
            ->andWhere('deleted')->eq(0)
            ->fetchPairs('id', 'name');
    }

    /**
     * Create contract.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $contract = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->add('status', 'normal')
            ->add('delivery', 'wait')
            ->add('return', 'wait')
            ->setDefault('order', array())
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->get();

        $this->dao->insert(TABLE_CONTRACT)->data($contract, 'order,uid,files,labels,real')
            ->autoCheck()
            ->batchCheck($this->config->contract->require->create, 'notempty')
            ->checkIF($contract->end != '0000-00-00', 'end', 'ge', $contract->begin)
            ->exec();

        $contractID = $this->dao->lastInsertID();

        if(!dao::isError())
        {
            foreach($contract->order as $orderID)
            {
                $data = new stdclass();
                $data->contract = $contractID;
                $data->order    = $orderID;
                $this->dao->insert(TABLE_CONTRACTORDER)->data($data)->exec();
            }

            foreach($contract->real as $real)
            {
                $order = new stdclass();
                $order->status     = 'signed';
                $order->real       = $real;
                $order->signedBy   = $contract->signedBy;
                $order->signedDate = $contract->signedDate;
                $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($orderID)->exec();
            }

            $this->loadModel('file')->saveUpload('contract', $contractID);

            return $contractID;
        }

        return false;
    }

    /**
     * Update contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function update($contractID)
    {
        $now      = helper::now();
        $contract = $this->getByID($contractID);
        $data     = fixer::input('post')
            ->join('handlers', ',')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->setDefault('order', array())
            ->setDefault('customer', $contract->customer)
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->remove('uid,files,labels')
            ->get();

        $this->dao->update(TABLE_CONTRACT)->data($data, 'order,real')
            ->where('id')->eq($contractID)
            ->autoCheck()
            ->batchCheck($this->config->contract->require->edit, 'notempty')
            ->checkIF($contract->end != '0000-00-00', 'end', 'ge', $contract->begin)
            ->exec();
        
        if(!dao::isError())
        {
            if($contract->order != $data->order)
            {
                $this->dao->delete()->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->exec();
                foreach($data->order as $orderID)
                {
                    $contractOrder = new stdclass();
                    $contractOrder->contract = $contractID;
                    $contractOrder->order    = $orderID;
                    $this->dao->insert(TABLE_CONTRACTORDER)->data($contractOrder)->exec();
                }
            }

            foreach($data->real as $key => $real)
            {
                $order = new stdclass();
                $order->real       = $real;
                $order->signedBy   = $data->signedBy;
                $order->signedDate = $data->signedDate;
                $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($data->order[$key])->exec();
            }
            $this->loadModel('file')->saveUpload('contract', $contractID);

            unset($data->real);
            $data->order     = join(',', $data->order);
            $contract->order = join(',', $contract->order);
            return commonModel::createChanges($contract, $data);
        }

        return false;
    }

    /**
     * The delivery of the contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function delivery($contractID)
    {
        $contract = new stdclass();
        $contract->delivery      = 'done';
        $contract->deliveredBy   = $this->app->user->account;
        $contract->deliveredDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Receive payments of the contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function receive($contractID)
    {
        $contract = new stdclass();
        $contract->return       = 'done';
        $contract->returnedBy   = $this->app->user->account;
        $contract->returnedDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Cancel contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function cancel($contractID)
    {
        $contract = new stdclass();
        $contract->status       = 'canceled';
        $contract->canceledBy   = $this->app->user->account;
        $contract->canceledDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Finish contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function finish($contractID)
    {
        $contract = new stdclass();
        $contract->status       = 'closed';
        $contract->finishedBy   = $this->app->user->account;
        $contract->finishedDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }
}
