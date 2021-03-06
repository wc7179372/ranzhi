<?php
/**
 * The control file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class blog extends control
{
    public function __CONSTRUCT()
    {
        parent::__CONSTRUCT();

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 8, 1);
        
        $this->view->latestArticles = $this->loadModel('article', 'sys')->getList('blog', 0, null, null, 'id_desc');
        $this->view->authors        = $this->loadModel('article', 'sys')->getAuthorList('blog');
        $this->view->months         = $this->loadModel('article', 'sys')->getMonthList('blog');
        $this->view->tags           = array_unique($this->loadModel('article', 'sys')->getTagList('blog'));
        $this->view->latestComments = $this->loadModel('message', 'sys')->getList('comment', 'blog', '');
    }

    /** 
     * Browse blog in front.
     * 
     * @param int    $categoryID   the category id
     * @param  string $author 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function index($categoryID = 0, $author = '', $month = '', $tag = '', $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        unset($this->lang->blog->menu);
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $category   = $this->loadModel('tree')->getByID($categoryID, 'blog');
        $categoryID = is_numeric($categoryID) ? $categoryID : $category->id;

        $where = '';
        if($author) $where .= "author = '{$author}'";
        if($tag)    $where .= "concat(',', keywords, ',') like ',%{$tag}%,'";
        if($month)  $where .= "createdDate like '" . str_replace('_', '-', $month) . "%'";

        $articles   = $this->loadModel('article')->getList('blog', $this->tree->getFamily($categoryID, 'blog'), 'query', $where, $orderBy = 'id_desc', $pager);
        $title      = '';

        if($category)
        {
            $title    = $category->name;
            $desc     = strip_tags($category->desc);
            $this->session->set('articleCategory', $category->id);
        }

        $this->view->title    = $title;
        $this->view->category = $category;
        $this->view->articles = $articles;
        $this->view->users    = $this->loadModel('user')->getPairs();
        $this->view->pager    = $pager;

        $this->display();
    }

    /**
     * Create a blog.
     * 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function create($categoryID = '')
    {
        $categories = $this->loadModel('tree')->getOptionMenu('blog', 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::locate($this->createLink('tree', 'redirect', "type=blog")));
        }

        if($_POST)
        {
            $this->article->create('blog');
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('team.blog')));
        }

        $this->view->title           = $this->lang->blog->create;
        $this->view->currentCategory = $categoryID;
        $this->view->categories      = $this->loadModel('tree')->getOptionMenu('blog', 0, $removeRoot = true);
        $this->view->type            = 'blog';

        $this->display();
    }

    /**
     * Edit an article.
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function edit($articleID)
    {
        $article    = $this->article->getByID($articleID, $replaceTag = false);
        $categories = $this->loadModel('tree')->getOptionMenu('blog', 0, $removeRoot = true);

        if($_POST)
        {
            $this->article->update($articleID, 'blog');
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('team.blog')));
        }

        $this->view->title      = $this->lang->article->edit;
        $this->view->article    = $article;
        $this->view->categories = $categories;
        $this->view->type       = 'blog';
        $this->display();
    }
    
    /**
     * View an article.
     * 
     * @param int $articleID 
     * @param int $currentCategory 
     * @access public
     * @return void
     */
    public function view($articleID, $currentCategory = 0)
    {
        unset($this->lang->blog->menu);
        $article  = $this->loadModel('article')->getByID($articleID);

        /* fetch category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->articleCategory;
        if($currentCategory > 0 && isset($article->categories[$currentCategory])) $category = $currentCategory;  
        $category = $this->loadModel('tree')->getByID($category);

        $title    = $article->title . ' - ' . $category->name;
        
        $this->view->title       = $title;
        $this->view->article     = $article;
        $this->view->prevAndNext = $this->loadModel('article')->getPrevAndNext($article->id, $category->id);
        $this->view->category    = $category;
        $this->view->users       = $this->loadModel('user')->getPairs();

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
        $this->display();
    }

    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID)
    {
        if($this->article->delete($articleID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
