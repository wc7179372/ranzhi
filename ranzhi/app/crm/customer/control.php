<?php
/**
 * The control file of customer module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class customer extends control
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
     * Browse customer.
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
        
        $this->view->title     = $this->lang->customer->list;
        $this->view->customers = $this->customer->getList($orderBy, $pager);
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }   

    /**
     * Create a customer.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $this->customer->create();       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title = $this->lang->customer->create;
        $this->display();
    }

    /**
     * Edit a customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function edit($customerID)
    {
        if($_POST)
        {
            $this->customer->update($customerID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }


        $this->view->title    = $this->lang->customer->edit;
        $this->view->customer = $this->customer->getByID($customerID);

        $this->display();
    }

    /**
     * Delete a customer.
     *
     * @param  int    $customerID
     * @access public
     * @return void
     */
    public function delete($customerID)
    {
        if($this->customer->delete($customerID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
