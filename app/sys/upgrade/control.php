<?php
/**
 * The control file of upgrade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class upgrade extends control
{
    /**
     * Construct, check the user can upgrade or not.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * The index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        if(version_compare($this->config->installedVersion, '1.3.beta', '>')) $this->locate(inlink('backup'));
        $this->display();
    }

    /**
     * The backup page.
     * 
     * @access public
     * @return void
     */
    public function backup()
    {
        $this->view->title = $this->lang->upgrade->backup;
        $this->view->db    = $this->config->db;
        $this->display();
    }

    /**
     * Select the version of old zentao.
     * 
     * @access public
     * @return void
     */
    public function selectVersion()
    {
        $version = str_replace(array(' ', '.'), array('', '_'), $this->config->installedVersion);
        $version = strtolower($version);

        $this->view->title   = $this->lang->upgrade->common . $this->lang->colon . $this->lang->upgrade->selectVersion;
        $this->view->version = $version;
        $this->display();
    }

    /**
     * Confirm the version.
     * 
     * @access public
     * @return void
     */
    public function confirm()
    {
        $this->view->title       = $this->lang->upgrade->confirm;
        $this->view->confirm     = $this->upgrade->getConfirm($this->post->fromVersion);
        if($this->view->confirm == '')
        {
            $this->view->result = 'success';
            $this->display('upgrade', 'execute');
            exit;
        }
        $this->view->fromVersion = $this->post->fromVersion;

        $this->display();
    }

    /**
     * Execute the upgrading.
     * 
     * @access public
     * @return void
     */
    public function execute()
    {
        $this->upgrade->execute($this->post->fromVersion);

        $this->view->title = $this->lang->upgrade->result;

        if(!$this->upgrade->isError())
        {
            $this->view->result = 'success';
        }
        else
        {
            $this->view->result = 'fail';
            $this->view->errors = $this->upgrade->getError();
        }
        $this->display();
    }
}
