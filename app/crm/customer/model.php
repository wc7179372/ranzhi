<?php
/**
 * The model file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class customerModel extends model
{
    /**
     * Get customer by id.
     * 
     * @param  int    $id 
     * @access public
     * @return int|bool
     */
    public function getByID($id)
    {
        $mine = $this->getMine();
        if(empty($mine)) return false;
        if(!in_array($id, $mine)) return false;

        return $this->dao->select('*')->from(TABLE_CUSTOMER)->where('id')->eq($id)->limit(1)->fetch();
    }

    /**
     * Get my customer id list.
     * 
     * @access public
     * @return array
     */
    public function getMine()
    {
        $customerList = $this->dao->select('*')->from(TABLE_CUSTOMER)
            ->beginIF(!isset($this->app->user->rights['crm']['manageall']) and ($this->app->user->admin != 'super'))
            ->where('assignedTo')->eq($this->app->user->account)->orWhere('public')->eq('1')
            ->fi()
            ->fetchAll('id');
        return array_keys($customerList);
    }

    /** 
     * Get customer list.
     * 
     * @param  string  $mode 
     * @param  mix     $param 
     * @param  string  $relation  client|provider
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($mode = 'all', $param = null, $relation = 'client', $orderBy = 'id_desc', $pager = null)
    {
        $mine = $this->getMine();
        if(empty($mine)) return array();
        $this->app->loadClass('date', $static = true);
        $thisMonth  = date::getThisMonth();
        $thisWeek   = date::getThisWeek();

        return $this->dao->select('*')->from(TABLE_CUSTOMER)
            ->where('deleted')->eq(0)
            ->beginIF($relation == 'client')->andWhere('relation')->ne('provider')
            ->beginIF($relation == 'provider')->andWhere('relation')->ne('client')
            ->beginIF($mode == 'field')->andWhere('mode')->eq($param)->fi()
            ->beginIF($mode == 'past')->andWhere('nextDate')->andWhere('nextDate')->lt(helper::today())->fi()
            ->beginIF($mode == 'today')->andWhere('nextDate')->eq(helper::today())->fi()
            ->beginIF($mode == 'tomorrow')->andWhere('nextDate')->eq(formattime(date::tomorrow(), DT_DATE1))->fi()
            ->beginIF($mode == 'thisweek')->andWhere('nextDate')->between($thisWeek['begin'], $thisWeek['end'])->fi()
            ->beginIF($mode == 'thismonth')->andWhere('nextDate')->between($thisMonth['begin'], $thisMonth['end'])->fi()
            ->beginIF($mode == 'public')->andWhere('public')->eq('1')->fi()
            ->beginIF($mode == 'query')->andWhere($param)->fi()
            ->beginIF($mode != 'all')->andWhere('nextDate')->ne('0000-00-00')->fi()
            ->andWhere('id')->in($mine)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /** 
     * Get customer pairs.
     * 
     * @param  string  $mode 
     * @param  mix     $param 
     * @param  string  $orderBy 
     * @param  bool    $emptyOption 
     * @access public
     * @return array
     */
    public function getPairs($relation = '', $emptyOption = true)
    {
        $mine = $this->getMine();
        if(empty($mine)) return array();

        $customers = $this->dao->select('id, name')->from(TABLE_CUSTOMER)
            ->where('deleted')->eq(0)
            ->beginIF($relation == 'client')->andWhere('relation')->ne('provider')
            ->beginIF($relation == 'provider')->andWhere('relation')->ne('client')
            ->orderBy('id_desc')
            ->fetchPairs('id');

        if($emptyOption)  $customers = array('' => '') + $customers;
        return $customers;
    }

    /**
     * Create a customer.
     * 
     * @param  object    $customer 
     * @access public
     * @return int
     */
    public function create($customer = null, $relation = 'client')
    {
        $now = helper::now();
        if(empty($customer))
        {
            $customer = fixer::input('post')
                ->setIF($this->post->name == '', 'name', $this->post->contact)
                ->add('relation', $relation)
                ->setIF($relation == 'provider', 'public', 1)
                ->add('createdBy', $this->app->user->account)
                ->add('assignedTo', $this->app->user->account)
                ->add('createdDate', $now)
                ->get();
        }

        if(!isset($customer->contact)) $this->config->customer->require->create = 'name';
        $this->dao->insert(TABLE_CUSTOMER)
            ->data($customer, $skip = 'uid,contact,email,qq,phone')
            ->autoCheck()
            ->batchCheck($this->config->customer->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $customerID = $this->dao->lastInsertID();

        if(isset($customer->contact))
        {
            $contact = new stdclass();
            $contact->customer    = $customerID;
            $contact->realname    = $customer->contact;
            $contact->phone       = $customer->phone;
            $contact->email       = $customer->email;
            $contact->qq          = $customer->qq;
            $contact->createdBy   = $this->app->user->account;
            $contact->createdDate = $now;

            $contactID = $this->loadModel('contact')->create($contact);

            if(dao::isError()) return false;
            $this->loadModel('action')->create('contact', $contactID, 'Created');
        }

        return $customerID;
    }

    /**
     * Update a customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return array
     */
    public function update($customerID)
    {
        $oldCustomer = $this->getByID($customerID);
        $customer    = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->stripTags('desc', $this->config->allowedTags->admin)
            ->get();

        /* Add http:// in head when that has not http:// or https://. */
        if(strpos($customer->site, '://') === false )  $customer->site  = 'http://' . $customer->site;
        if(strpos($customer->weibo, 'http://weibo.com/') === false ) $customer->weibo = 'http://weibo.com/' . $customer->weibo;
        if($customer->site == 'http://') $customer->site = '';
        if($customer->weibo == 'http://weibo.com/') $customer->weibo = '';

        $this->dao->update(TABLE_CUSTOMER)
            ->data($customer, $skip = 'uid')
            ->autoCheck()
            ->batchCheck($this->config->customer->require->edit, 'notempty')
            ->where('id')->eq($customerID)
            ->exec();

        if(dao::isError()) return false;
        return commonModel::createChanges($oldCustomer, $customer);
    }

    /**
     * Assign an customer to a member again.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function assign($customerID)
    {
        $customer = fixer::input('post')
            ->setDefault('assignedBy', $this->app->user->account)
            ->setDefault('assignedDate', helper::now())
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_CUSTOMER)
            ->data($customer, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($customerID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Link contact.
     * 
     * @param  int    $customerID 
     * @access public
     * @return bool
     */
    public function linkContact($customerID)
    {
        $this->loadModel('action');
        $this->loadModel('contact');
        if($this->post->newContact)
        {
            $contact = fixer::input('post')
                ->add('customer', $customerID)
                ->add('createdBy', $this->app->user->account)
                ->add('createdDate', helper::now())
                ->remove('newContact,contact')
                ->get();

            $contactID = $this->contact->create($contact);

            if($contactID) $this->action->create('contact', $contactID, 'Created');
            return $contactID;
        }

        if($this->post->contact)
        {
            $contactID = $this->post->contact;
            $contact   = $this->contact->getByID($contactID);

            if($contact->customer != $customerID)
            {
                $resume = new stdclass();
                $resume->customer = $customerID;
                $resume->contact  = $contactID;
                $resumeID = $this->loadModel('resume')->create($contactID, $resume);

                if($resumeID)
                {
                    $changes[] = array('field' => 'customer', 'old' => $contact->customer, 'new' => $customerID, 'diff' => '');
                    $actionID  = $this->action->create('contact', $contactID, 'Edited');
                    $this->action->logHistory($actionID, $changes);
                }

                return $resumeID;
            }
        }

        return false;
    }

    /**
     * Combine sizeList for customer.
     * 
     * @access public
     * @return array
     */
    public function combineSizeList()
    {
        $sizeList = array();
        foreach($this->lang->customer->sizeNameList as $key => $sizeName)
        {
            $sizeList[$key] = $sizeName . '(' . $this->lang->customer->sizeNoteList[$key] . ')';
            if(empty($sizeName)) $sizeList[$key] = '';
        }
        return $sizeList;
    }

    /**
     * Combine levelList for customer.
     * 
     * @access public
     * @return array
     */
    public function combineLevelList()
    {
        $levelList = array();
        foreach($this->lang->customer->levelNameList as $key => $levelName)
        {
            $levelList[$key] = $levelName . '(' . $this->lang->customer->levelNoteList[$key] . ')';
            if(empty($levelName)) $levelList[$key] = '';
        }
        return $levelList;
    }
}
