<?php
/**
/**
 * The control file of effort module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     effort
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class effort extends control
{
    /**
     * Create for object.
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @param  string $account 
     * @param  string $date 
     * @access public
     * @return void
     */
    public function createForObject($objectType, $objectID, $account = '', $date = '')
    {
        if(!empty($_POST))
        {
            $result = $this->effort->batchCreate();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(!$result['result']) $this->send($result);

            $url = $this->session->effortList ? $this->session->effortList : inlink('view', "effortID=$effortID");
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $url));
        }

        $date = $date ?  substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2) : date(DT_DATE1);
        if($account == '') $account = $this->app->user->account;

        $users   = $this->loadModel('user')->getPairs('noletter,noclosed,nodeleted');
        $efforts = $this->effort->getByObject($objectType, $objectID);
        if(isset($efforts['typeList']))
        {   
            $this->view->typeList = $efforts['typeList'];
            unset($efforts['typeList']);
        }   

        $this->session->set('effortList', $this->app->getURI());

        $this->view->title      = $this->lang->effort->create;

        $this->view->date       = $date;
        $this->view->efforts    = $efforts;
        $this->view->users      = $users;
        $this->view->account    = $account;
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->display();
    }   

   /**
    * Edit effort.
    * 
    * @param  int    $effortID 
    * @access public
    * @return void
    */
   public function edit($effortID)
    {
        if(!empty($_POST))
        {
            $changes = $this->effort->update($effortID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('effort', $effortID, 'edited');
                $this->action->logHistory($actionID, $changes);
            }

            $url = $this->session->effortList ? $this->session->effortList : inlink('view', "effortID=$effortID");
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $url));
        }

        /* Judge a private effort or not, If private, die. */
        $effort       = $this->effort->getById($effortID);
        $effort->date = (int)$effort->date == 0 ? $effort->date : substr($effort->date, 0, 4) . '-' . substr($effort->date, 4, 2) . '-' . substr($effort->date, 6, 2);

        $this->view->title  = $this->lang->effort->edit;
        $this->view->effort = $effort;
        $this->display();
    }

    /**
     * Delete effort. 
     * 
     * @param  int    $effortID 
     * @access public
     * @return void
     */
    public function delete($effortID)
    {
            $effort = $this->effort->getByID($effortID);
            $this->effort->changeTaskConsumed($effort, 'delete');

            $this->dao->delete()->from(TABLE_EFFORT)->where('id')->eq($effortID)->exec();
            $this->dao->delete()->from(TABLE_ACTION)->where('objectType')->eq('effort')->andWhere('objectID')->eq($effortID)->exec();
            if(dao::isError()) $this->send(array('result' => 'success', 'message' => dao::getError()));
            $this->send(array('result' => 'success'));
    }
}
