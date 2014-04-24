<?php
/**
 * The control file of action module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class action extends control
{
    /**
     * Edit comment of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function editComment($actionID)
    {
        if(!strip_tags($this->post->lastComment)) $this->send(array('result' => 'success', 'locate' => $this->server->http_referer));
        $this->action->updateComment($actionID);
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
    }

    /**
     * Create one record of an object.
     * 
     * @param  string    $objectType  order|contact|customer
     * @param  int       $objectID 
     * @param  int       $customer 
     * @access public
     * @return void
     */
    public function createRecord($objectType, $objectID, $customer = 0)
    {
        if($_POST)
        {
            $this->action->createRecord($objectType, $objectID, $customer);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browserecord', "orderID={$orderID}")));
        }

        $this->view->title      = $this->lang->action->record->create;
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->view->customer   = $customer;
        $this->view->contacts   = $this->loadModel('contact', 'crm')->getPairs($customer);
        $this->display();
    }

   /**
     * Edit one record of an object.
     * 
     * @param  int    $recordID
     * @access public
     * @return void
     */
    public function editRecord($recordID)
    {
        $record = $this->loadModel('action')->getByID($recordID);
        if($record->action != 'record') exit;
        $object = $this->loadModel($record->objectType)->getByID($record->objectID);

        if($_POST)
        {
            $action = fixer::input('post')->get();
            $this->action->update($action, $recordID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title    = $this->lang->action->record->edit;
        $this->view->record   = $record;
        $this->view->contacts = $this->loadModel('contact')->getPairs($object->customer);
        $this->display();
    }
}
