<?php
/**
 * The control file for block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class block extends control
{
    /**
     * Block Index Page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $lang = $this->get->lang;
        $this->app->setClientLang($lang);
        $this->app->loadLang('common', 'crm');
        $this->app->loadLang('block');

        $mode = strtolower($this->get->mode);
        if($mode == 'getblocklist')
        {   
            die($this->block->getBlockList());
        }   
        elseif($mode == 'getblockform')
        {   
            $code = strtolower($this->get->blockid);
            $func = 'get' . ucfirst($code) . 'Params';
            die($this->block->$func());
        }   
        elseif($mode == 'getblockdata')
        {   
            $code = strtolower($this->get->blockid);
            $func = 'print' . ucfirst($code) . 'Block';
            $this->$func();
        }   
    }

    /**
     * Block Admin Page.
     * 
     * @param  int    $index 
     * @param  string $blockID 
     * @access public
     * @return void
     */
    public function admin($index, $blockID = '')
    {
        if($_POST)
        {
            $this->block->save($index);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror())); 
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->app->loadLang('block', 'sys');

        $blocks     = json_decode($this->block->getBlockList());
        $blockPairs = array('' => '');
        foreach($blocks as $code => $block) $blockPairs[$code] = $block->name;

        $personalBlocks = isset($this->config->personal->index->block) ? $this->config->personal->index->block : new stdclass();
        $block          = (isset($personalBlocks->{'b' . $index}) and $personalBlocks->{'b' . $index}->app == 'crm') ? json_decode($personalBlocks->{'b' . $index}->value) : array();
        $blockID        = $blockID ? $blockID : (($block and $personalBlocks->{'b' . $index}->app == 'crm') ? $block->blockID : '');

        $this->view->blocks  = $blockPairs;
        $this->view->params  = $blockID ? json_decode($this->block->{'get' . ucfirst($blockID) . 'Params'}(), true) : array();;
        $this->view->blockID = $blockID;
        $this->view->block   = $block;
        $this->view->index   = $index;
        $this->display();
    }

    /**
     * Sort block. 
     * 
     * @param  string    $oldOrder 
     * @param  string    $newOrder 
     * @access public
     * @return void
     */
    public function sort($oldOrder, $newOrder)
    {
        $this->app->setAppName('sys');
        $this->locate(inlink('sort', "oldOrder=$oldOrder&newOrder=$newOrder&app=crm"));
    }

    /**
     * Delete block. 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function delete($index)
    {
        $this->app->setAppName('sys');
        $this->locate(inlink('delete', "index=$index&app=crm"));
    }

    /**
     * Print order block.
     * 
     * @access public
     * @return void
     */
    public function printOrderBlock()
    {
        $this->lang->order = new stdclass();
        $this->app->loadLang('order');

        $params = $this->get->param;
        $params = json_decode(base64_decode($params));

        $this->view->sso       = base64_decode($this->get->sso);
        $this->view->code      = $this->get->blockid;
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();

        $this->view->orders = $this->dao->select('*')->from(TABLE_ORDER)
            ->where("(createdBy='$params->account' OR assignedTo = '$params->account')")
            ->beginIF(isset($params->status) and join($params->status) != false)->andWhere('status')->in($params->status)->fi()
            ->orderBy($params->orderBy)
            ->limit($params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print task block.
     * 
     * @access public
     * @return void
     */
    public function printTaskBlock()
    {
        $this->lang->task = new stdclass();
        $this->app->loadLang('task');

        $params = $this->get->param;
        $params = json_decode(base64_decode($params));

        $this->view->sso    = base64_decode($this->get->sso);
        $this->view->code   = $this->get->blockid;


        $this->view->tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where("(createdBy='$params->account' OR assignedTo = '$params->account')")
            ->beginIF(isset($params->status) and join($params->status) != false)->andWhere('status')->in($params->status)->fi()
            ->orderBy($params->orderBy)
            ->limit($params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print contract block.
     * 
     * @access public
     * @return void
     */
    public function printContractBlock()
    {
        $this->lang->contract = new stdclass();
        $this->app->loadLang('contract');

        $params = $this->get->param;
        $params = json_decode(base64_decode($params));

        $this->view->sso    = base64_decode($this->get->sso);
        $this->view->code   = $this->get->blockid;


        $this->view->contracts = $this->dao->select('*')->from(TABLE_CONTRACT)
            ->where('createdBy')->eq($params->account)
            ->beginIF(isset($params->status) and join($params->status) != false)->andWhere('status')->in($params->status)->fi()
            ->orderBy($params->orderBy)
            ->limit($params->num)
            ->fetchAll('id');

        $this->display();
    }
}
