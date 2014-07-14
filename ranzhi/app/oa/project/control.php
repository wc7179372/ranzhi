<?php
/**
 * The control file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project
 * @version     $Id: control.php 7417 2013-12-23 07:51:50Z wwccss $
 * @link        http://www.ranzhi.org
 */
class project extends control
{
    public function __construct()
    {
        parent::__construct();

        $this->projects = $this->project->getPairs();
    }

    /**
     * index page of project module.
     * 
     * @param  string $status 
     * @access public
     * @return void
     */
    public function index($status = 'doing')
    {
        if(empty($this->projects)) $this->locate(inlink('create'));
        $this->view->status   = $status;
        $this->view->projects = $this->project->getList($status);
        $this->display();
    }

    /**
     * create a project.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $projectID = $this->project->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('task', 'browse', "projectID={$projectID}")));
        }

        $this->view->title = $this->lang->project->create;
        $this->display();
    }

    /**
     * Edit project. 
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function edit($projectID)
    {
        if($_POST)
        {
            $changes  = $this->project->update($projectID);
            $actionID = $this->loadModel('action')->create('project', $projectID, 'Edited');
            if($changes) $this->action->logHistory($actionID, $changes);

            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title   = $this->lang->project->edit;
        $this->view->project = $this->project->getByID($projectID);
        $this->display();
    }

    /**
     * Finish project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function finish($projectID) 
    {
        if($_POST)
        {
            $changes = $this->project->finish($projectID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('project', $projectID, 'Finished', $this->post->comment);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $project = $this->project->getByID($projectID);

        $this->view->title     = $project->name;
        $this->view->projectID = $projectID;
        $this->view->project   = $project;
        $this->display();
    }

    /**
     * Active project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function activate($projectID)
    {
        $result = $this->project->activate($projectID);
        if($result) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Delete a project.
     *
     * @param  int    $projectID
     * @access public
     * @return void
     */
    public function delete($projectID)
    {
        $this->project->delete(TABLE_PROJECT, $projectID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success'));
    }
}
