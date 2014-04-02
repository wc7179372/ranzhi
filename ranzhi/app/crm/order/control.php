<?php
/**
 * The control file of order module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class order extends control
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
     * Browse order.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title     = $this->lang->order->browse;
        $this->view->orders    = $this->order->getList($orderBy, $pager);
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return viod
     */
    public function create()
    {
        if($_POST)
        {
            $orderID = $this->order->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('order', $orderID, 'Created', '');
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $products = $this->loadModel('product')->getPairs();
        $this->view->products  = array( 0 => '') + $products;
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->title     = $this->lang->order->create;

        $this->display();
    }

    /**
     * Edit an order.
     * 
     * @param  int $orderID 
     * @access public
     * @return void
     */
    public function edit($orderID)
    {
        if($_POST)
        {
            $changes = $this->order->update($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(!empty($changes))
            {   
                $actionID = $this->loadModel('action')->create('order', $orderID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }   
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title     = $this->lang->order->edit;
        $this->view->order     = $this->order->getByID($orderID);
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->actions   = $this->loadModel('action')->getList('order', $orderID);

        $this->display();
    }

    /**
     * View an order.
     * 
     * @param  int $orderID 
     * @access public
     * @return void
     */

    public function view($orderID)
    {
        $order    = $this->order->getByID($orderID);
        $product  = $this->loadModel('product')->getByID($order->product);
        $customer = $this->loadModel('customer')->getByID($order->customer);
    
        $this->view->order      = $order;
        $this->view->product    = $product;
        $this->view->customer   = $customer;
        $this->view->efforts    = $this->loadModel('effort')->getByObject('order', $orderID);
        $this->view->actions    = $this->order->getEnabledActions($order);
        $this->view->actionList = $this->loadModel('action')->getList('order', $orderID);
    
        $this->display();
    }
    
    /**
     * Close an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function close($orderID) 
    {
        if(!empty($_POST))
        {
            $this->order->close($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('order', $orderID, 'Closed', $this->post->closedNote);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->orderID = $orderID;
        $this->display();
    }

    /**
     * Activate an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function activate($orderID) 
    {
        $this->order->activate($orderID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->loadModel('action')->create('order', $orderID, 'Activated', '');
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }

    /**
     * Browse team of an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function team($orderID = 0)
    {
        $roles        = $this->lang->user->roleList;
        $order        = $this->order->getByID($orderID);
        $productRoles = $this->loadModel('product')->getRoleList($order->product);
        if($productRoles)
        {
            $roles = array_merge($roles, $productRoles);
        }

        $this->view->roles       = $roles;
        $this->view->title       = $this->lang->order->team;
        $this->view->order       = $order;
        $this->view->teamMembers = $this->order->getTeamMembers($orderID);

        $this->display();
    }

    /**
     * Manage members of the order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function manageMembers($orderID = 0)
    {
        if(!empty($_POST))
        {
            $this->order->manageMembers($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => $this->createLink('order', 'team', "orderID=$orderID")));
        }

        $this->loadModel('user');

        $order          = $this->order->getById($orderID);
        $users          = $this->user->getPairs('noclosed, nodeleted, devfirst');
        $currentMembers = $this->order->getTeamMembers($orderID);
        $roles          = $this->lang->user->roleList;
        $productRoles   = $this->loadModel('product')->getRoleList($order->product);
        if($productRoles)
        {
            $roles = array_merge($roles, $productRoles);
        }


        /* The deleted members. */
        foreach($currentMembers as $account => $member)
        {
            if(!isset($users[$member->account])) $member->account .= $this->lang->user->deleted;
        }

        $this->view->title          = $this->lang->order->manageMembers;
        $this->view->order          = $order;
        $this->view->users          = $users;
        $this->view->userRoles      = $this->user->getUserRoles(array_keys($users));
        $this->view->roles          = $roles;
        $this->view->currentMembers = $currentMembers;
        $this->display();
    }

    /**
     * Unlink a memeber.
     * 
     * @param  int    $orderID 
     * @param  string $account 
     * @access public
     * @return void
     */
    public function unlinkMember($orderID, $account)
    {
        if($this->order->unlinkMember($orderID, $account)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Operate an order.
     * 
     * @param  int    $orderID 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function operate($orderID, $actionID)
    {
        $order  = $this->order->getByID($orderID); 
        $action = $this->loadModel('product')->getActionByID($actionID);

        if($_POST)
        {
            if($this->order->operate($order, $action))
            {
                $this->loadModel('action')->create('order', $orderID, $action->action, '', $action->name);
                $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('tasks', "orderID={$orderID}&actionID={$actionID}")));
            }
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        
        $customFields = $this->product->getFieldList($order->product);

        $this->view->fields = array_merge($this->lang->order->fields, $customFields);
        $this->view->order  = $order;
        $this->view->action = $action;
        $this->display();
    }

    /**
     * create tasks after order operates.
     * 
     * @param  int    $orderID 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function tasks($orderID, $actionID)
    {
        $this->loadModel('task');
        $this->loadModel('user', 'sys');
        $action = $this->loadModel('product')->getActionByID($actionID);
        if(empty($action->tasks)) $this->locate(inlink('browse'));
        $order  = $this->order->getByID($orderID);

        if($_POST)
        {
            if($this->order->createTasks($order)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('browse')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        
        $this->view->title  = $this->lang->order->createTasks;
        $this->view->team   = $this->order->getRoleList($orderID);
        $this->view->action = $action;
        $this->view->order  = $order;
        $this->display();
    }

    /**
     * Get contact of an customer.
     *
     * @param  int    $order
     * @param  string $orderBy     the order by
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function contact($order, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $order = $this->order->getByID($order);
        $contacts = $this->loadModel('contact')->getList($order->customer, $orderBy, $pager);

        $this->view->title    = $this->lang->order->contact;
        $this->view->contacts = $contacts;
        $this->view->pager    = $pager;

        $this->display();
    }
}