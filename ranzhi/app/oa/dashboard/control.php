<?php
/**
 * The control file of dashboard module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     dashboard
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class dashboard extends control
{
    /**
     * Dsahboard Index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->app->loadLang('index', 'sys');
        $appName  = $this->app->getAppName();
        $personal = isset($this->config->personal->index) ? $this->config->personal->index : array();
        $blocks   = empty($personal->block) ? array() : (array)$personal->block;
        foreach($blocks as $key => $block)
        {
            if($block->app != $appName) unset($blocks[$key]);
        }

        /* Init block when vist index first. */
        if(empty($blocks) and empty($this->config->init->block))
        {
            if($this->loadModel('block', 'sys')->initBlock($appName)) $this->locate(inlink('index'));
        }

        foreach($blocks as $key => $block)
        {
            $block->value = json_decode($block->value);

            $block->value->params->account = $this->app->user->account;
            $block->value->params->uid     = $this->app->user->id;

            $query            = array();
            $query['mode']    = 'getblockdata';
            $query['blockid'] = $block->value->blockID;
            $query['param']   = base64_encode(json_encode($block->value->params));
            $query['hash']    = '';
            $query['lang']    = $this->app->getClientLang();
            $query['sso']     = '';
            $query['app']     = $appName;

            $query = http_build_query($query);
            $sign  = $this->config->requestType == 'PATH_INFO' ? '?' : '&';

            $block->value->blockLink = $this->createLink('block', 'index') . $sign . $query;
        }

        ksort($blocks);

        $this->view->blocks   = $blocks;
        $this->view->newIndex = $blocks ? count($blocks) + 1 : 1;;
        $this->display();
    }
}
