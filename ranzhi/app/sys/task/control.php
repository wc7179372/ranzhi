<?php
/**
 * The control file of task module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class task extends control
{
    /** 
     * The index page, locate to browse.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $this->locate(inlink('browse'));
    }   

    /**
     * Browse task. 
     * 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title   = $this->lang->task->browse;
        $this->view->tasks   = $this->task->getList($orderBy, $pager);
        $this->view->pager   = $pager;
        $this->view->orderBy = $orderBy;
        $this->display();
    }

    /**
     * Create a task.
     * 
     * @param  int    $orderID
     * @param  int    $customerID
     * @access public
     * @return void
     */
    public function create($orderID = 0, $customerID = 0)
    {
        if($_POST)
        {
            $taskID = $this->task->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('task', $taskID, 'Created');
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $orders = $this->loadModel('order')->getPairs($customerID);

        $this->view->orders     = array('0' => '') + $orders;
        $this->view->customers  = $this->loadModel('customer')->getPairs();
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->view->orderID    = $orderID;
        $this->view->order      = $this->order->getByID($orderID);
        $this->view->customerID = $customerID;
        $this->display();
    }

    /**
     * Edit a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function edit($taskID)
    {
        if($_POST)
        {
            $changes = $this->task->update($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(!empty($changes))
            {   
                $actionID = $this->loadModel('action')->create('task', $taskID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }   
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->task      = $this->task->getByID($taskID);
        $this->view->orders    = $this->loadModel('order')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * View task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function view($taskID)
    {
        $task = $this->task->getByID($taskID);

        $this->view->orders    = $this->loadModel('order')->getPairs($task->customer);
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->view->task      = $task;
        $this->view->actions   = $this->loadModel('action')->getList('task', $taskID);

        $this->display();
    }

    /**
     * Finish task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function finish($taskID) 
    {
        if($_POST)
        {
            $this->task->finish($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('task', $taskID, 'Finished', $this->post->comment);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->taskID = $taskID;
        $this->view->task   = $this->task->getByID($taskID);
        $this->view->users  = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Update assign of task.
     *
     * @param  int    $taskID
     * @access public
     * @return void
     */
    public function assignTo($taskID)
    {
        if($_POST)
        {
            $this->task->assign($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if($this->post->assignedTo) $this->loadModel('action')->create('task', $taskID, 'Assigned', $this->post->comment, $this->post->assignedTo);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->taskID = $taskID;
        $this->view->task   = $this->task->getByID($taskID);
        $this->view->users  = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Get order.
     *
     * @param  int    $taskID
     * @access public
     * @return void
     */
    public function getOrder($customerID)
    {
        $orders = array('0' => '') + $this->loadModel('order')->getPairs($customerID);
        
        echo html::select('order', $orders, '', "class='form-control'");
    }
}