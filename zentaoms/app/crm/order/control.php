<?php
/**
 * The control file of order category of ZenTaoMS.
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
        
        $orders = $this->order->getList($orderBy, $pager);

        $this->view->title     = $this->lang->order->browse;
        $this->view->orders    = $orders;
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->pager     = $pager;
        $this->display();
    }

    /**
     * Create an order.
     * 
     * @param  int    $productID 
     * @access public
     * @return viod
     */
    public function create($productID = 0)
    {
        if($_POST)
        {
            $this->order->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }
        $this->view->productForm = '';
        if($productID) $this->view->productForm = $this->loadModel('product')->buildForm($productID);

        $this->view->productID = $productID;
        $this->view->title     = $this->lang->order->create;

        $products = $this->loadModel('product')->getPairs();
        $this->view->products  = array( 0 => '') + $products;
        $this->view->customers = $this->loadModel('customer')->getPairs();

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
            $this->order->update($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $order = $this->order->getByID($orderID);

        $this->view->title    = $this->lang->order->edit;
        $this->view->order    = $order;
        $this->view->products = $this->loadModel('product')->getPairs();

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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

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
        $this->view->title       = $this->lang->order->team;
        $this->view->order       = $this->order->getByID($orderID);
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
        $roles          = $this->user->getUserRoles(array_keys($users));
        $currentMembers = $this->order->getTeamMembers($orderID);

        /* The deleted members. */
        foreach($currentMembers as $account => $member)
        {
            if(!isset($users[$member->account])) $member->account .= $this->lang->user->deleted;
        }

        $this->view->title          = $this->lang->order->manageMembers;
        $this->view->order          = $order;
        $this->view->users          = $users;
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
}
