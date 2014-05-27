<?php
/**
 * The model file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class tradeModel extends model
{
    /**
     * Get trade by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get trade list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy, $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /**
     * Create a trade.
     * 
     * @param  string    $type   in|out
     * @access public
     * @return void
     */
    public function create($type)
    {
        $now = helper::now();
        $trade = fixer::input('post')
            ->add('type', $type)
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->get();

        $handler = $this->loadModel('user')->getByAccount($trade->handler);
        if($handler) $trade->dept = $handler->dept;

        $depositor = $this->loadModel('depositor')->getByID($trade->depositor);
        $trade->currency = $depositor->currency;

        $this->dao->insert(TABLE_TRADE)
            ->data($trade)
            ->autoCheck()
            ->batchCheck($this->config->trade->require->create, 'notempty')
            ->exec();

        return $this->dao->lastInsertID();
    }

    /**
     * Update a trade.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return string|bool
     */
    public function update($tradeID)
    {
        $oldDepositor = $this->getByID($tradeID);

        $trade = fixer::input('post')
            ->removeIF($this->post->type == 'cash', 'public')
            ->get();

        $handler = $this->loadModel('user')->getByAccount($trade->handler);
        if($handler) $trade->dept = $handler->dept;


        $this->dao->update(TABLE_TRADE)->data($trade)->autoCheck()->where('id')->eq($tradeID)->exec();

        if(!dao::isError()) return commonModel::createChanges($oldDepositor, $trade);

        return false;
    }

    /**
     * Transfer.
     * 
     * @access public
     * @return int|bool
     */
    public function transfer()
    {
        if($this->post->receipt == $this->post->payment) return array('result' => false, 'message' => $this->lang->trade->notEqual);
        $now = helper::now();
        $receipt = fixer::input('post')
            ->add('type', 'in')
            ->add('depositor', $this->post->receipt)
            ->add('transfer', '1')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->remove('receipt, payment, fee, feeCurrency')
            ->get();

        $handler = $this->loadModel('user')->getByAccount($receipt->handler);
        if($handler) $receipt->dept = $handler->dept;

        $this->dao->insert(TABLE_TRADE)
            ->data($receipt)
            ->autoCheck()
            ->batchCheck($this->config->trade->require->transfer, 'notempty')
            ->exec();

        $receiptID = $this->dao->lastInsertID();

        $this->loadModel('action')->create('trade', $receiptID, 'Created');

        $payment = $receipt;
        $payment->type      = 'out';
        $payment->depositor = $this->post->payment;

        $this->dao->insert(TABLE_TRADE)->data($payment)->exec();

        $receiptID = $this->dao->lastInsertID();

        $this->loadModel('action')->create('trade', $receiptID, 'Created');

        if($this->post->fee)
        {
            $fee = $payment;
            $fee->money    = $this->post->fee;
            $fee->currency = $this->post->feeCurrency;
            $fee->desc     = $this->lang->trade->fee;

            $this->dao->insert(TABLE_TRADE)->data($fee)->exec();

            $feeID = $this->dao->lastInsertID();

            $this->loadModel('action')->create('trade', $feeID, 'Created');
        }

        if(dao::isError()) return array('result' => false, 'message' => dao::getError());
    }

    /**
     * Delete a trade.
     * 
     * @param  int      $tradeID 
     * @access public
     * @return void
     */
    public function delete($tradeID, $null = null)
    {
        $trade = $this->getByID($tradeID);
        if(!$trade) return false;

        $this->dao->delete()->from(TABLE_TRADE)->where('id')->eq($tradeID)->exec();

        return !dao::isError();
    }

}
