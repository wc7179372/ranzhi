<?php
/**
 * The index view file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php 
include '../../common/view/header.html.php';
include '../../../sys/common/view/treeview.html.php';
$path = $category ? array_keys($category->pathNames) : array();
if(!empty($path))         js::set('path',  $path);
if(!empty($category->id)) js::set('categoryID', $category->id );
?>
<?php
$root = '<li>' . $this->lang->currentPos . $this->lang->colon .  html::a($this->inlink('index'), $lang->home) . '</li>';
if(!empty($category)) echo $common->printPositionBar($category, '', '', $root);
?>
<div id="mainContent">
  <div class='panel list list-condensed'>
    <div class='panel-heading'>
      <strong><i class='icon-calendar'></i><?php echo $lang->blog->browse;?></strong>
      <div class='panel-actions pull-right'>
        <?php echo html::a($this->createLink('article', 'create', "type=blog"), $lang->blog->create, "class='btn btn-primary'");?>
      </div>
    </div>
    <section class='items items-hover'>
      <?php foreach($articles as $article):?>
      <div class='item'>
        <div class='item-heading'>
          <div class="text-muted pull-right">
            <span title="<?php echo $users[$article->author];?>"><i class='icon-user'></i> <?php echo $users[$article->author];?></span> &nbsp; 
            <span title="<?php echo $lang->article->createdDate;?>"><i class='icon-time'></i> <?php echo substr($article->createdDate, 0, 10);?></span>&nbsp; 
          </div>
          <h4><?php echo $article->title;?></h4>
        </div>
        <div class='item-content'>
          <?php if(!empty($article->image)):?>
          <div class='media pull-right'>
            <?php
            $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
            echo html::a($url, html::image($article->image->primary->smallURL, "title='{$title}' class='thumbnail'" ));
            ?>
          </div>
          <?php endif;?>
          <div class='text'><?php echo $article->content;?></div>
          <div class='text pull-right'>
            <?php echo html::a($this->createLink('article', 'edit', "articleID={$article->id}&type=blog"), $lang->edit);?>
            <?php echo html::a($this->createLink('article', 'delete', "articleID={$article->id}"), $lang->delete, "class='deleter'");?>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </section>
    <footer class='clearfix'><?php $pager->show('right', 'short');?></footer>
  </div>
</div>

<?php include '../../common/view/footer.html.php';?>
