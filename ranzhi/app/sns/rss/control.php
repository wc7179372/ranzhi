<?php
/**
 * The control file of article category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class rss extends control
{
    /**
     * Output the rss.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $type = $this->get->type != false ? $this->get->type : 'blog';
        $this->loadModel('tree');
        $this->loadModel('article');

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, isset($this->config->rss->items) ? $this->config->rss->items : 10, 1);

        $articles = $this->article->getList($type, $this->tree->getFamily(0, $type), 'id_desc', $pager);
        $latestArticle = current((array)$articles);

        $this->view->title    = isset($this->config->company->name) ? $this->config->company->name : $this->lang->zentaoms;
        $this->view->desc     = isset($this->config->company->desc) ? $this->config->company->desc : '';
        $this->view->siteLink = $this->inlink('browse', "type={$type}");
        $this->view->siteLink = commonModel::getSysURL();

        $this->view->articles = $articles;
        $this->view->lastDate = $latestArticle ? $latestArticle->addedDate : date('Y-m-d H:i:s') . ' +0800';
         
        $this->display();
    }
}