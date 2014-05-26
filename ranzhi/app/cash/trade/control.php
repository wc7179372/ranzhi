<?php
/**
 * The control file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class trade extends control
{
    /** 
     * The index page, locate to the browse page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse trade.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $expenseTypes  = $this->loadModel('tree')->getPairs('expense', 0, $removeRoot = true);
        $incomeTypes   = $this->loadModel('tree')->getOptionMenu('income', 0, $removeRoot = true);

        $this->view->title   = $this->lang->trade->browse;
        $this->view->trades  = $this->trade->getList($orderBy, $pager);
        $this->view->pager   = $pager;
        $this->view->orderBy = $orderBy;

        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->orderList     = $this->loadModel('order', 'crm')->getPairs($customerID = 0);
        $this->view->contractList  = $this->loadModel('contract', 'crm')->getPairs($customerID = 0);
        $this->view->deptList      = $this->loadModel('tree')->getOptionMenu('dept', 0, $removeRoot = true);
        $this->view->categories    = $expenseTypes + $incomeTypes;
        $this->view->users         = $this->loadModel('user')->getPairs();

        $this->display();
    }   

    /**
     * Create a contact.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $tradeID = $this->trade->create(); 
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('trade', $tradeID, 'Created', '');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title         = $this->lang->trade->create;
        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->orderList     = $this->loadModel('order', 'crm')->getPairs($customerID = 0);
        $this->view->contractList  = $this->loadModel('contract', 'crm')->getPairs($customerID = 0);
        $this->view->expenseTypes  = $this->loadModel('tree')->getOptionMenu('expense', 0, $removeRoot = true);
        $this->view->incomeTypes   = $this->loadModel('tree')->getOptionMenu('income', 0, $removeRoot = true);
        $this->view->users         = $this->loadModel('user')->getPairs();

        $this->display();
    }

    /**
     * Edit a trade.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function edit($tradeID)
    {
        $trade = $this->trade->getByID($tradeID);
        if(empty($trade)) die();
        if($_POST)
        {
            $changes = $this->trade->update($tradeID);
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('trade', $tradeID, 'Edited', '');
                $this->action->logHistory($actionID, $changes);
            }
            
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }
       
        $this->view->title         = $this->lang->trade->edit;
        $this->view->trade         = $trade;
        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->orderList     = $this->loadModel('order', 'crm')->getPairs($customerID = 0);
        $this->view->contractList  = $this->loadModel('contract', 'crm')->getPairs($customerID = 0);
        $this->view->expenseTypes  = $this->loadModel('tree')->getOptionMenu('expense', 0, $removeRoot = true);
        $this->view->incomeTypes   = $this->loadModel('tree')->getOptionMenu('incom', 0, $removeRoot = true);
        $this->view->users         = $this->loadModel('user')->getPairs();


        $this->display();
    }

    /**
     * Delete a trade.
     * 
     * @param  int      $tradeID 
     * @access public
     * @return void
     */
    public function delete($tradeID)
    {
        if($this->trade->delete($tradeID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}