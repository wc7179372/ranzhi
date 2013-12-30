<?php
/**
 * The index view file of blog module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.zentao.net
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
<div class='row' id="blogBox">
  <div class='col-md-9'>
    <ul class="media-list">
    <?php foreach($articles as $article):?>
      <li class="media radius">
        <p class="pull-right"><strong class='dater'><?php echo date('Y/m/d', strtotime($article->addedDate));?></strong></p>
        <div class='media-body'>
          <h3 class='media-heading'><?php echo html::a(inlink('view', "id=$article->id", "category={$category->alias}&name=$article->alias"), $article->title);?></h3>
          <p>
            <?php 
            if(!empty($article->image))
            {
                $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
                echo html::image($article->image->primary->smallURL, "title='{$title}' class='thumbnail'");
            }
            ?>
            <?php echo $article->summary;?>
          </p>
        </div>
      </li>
    <?php endforeach;?>
    </ul>
    <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
    <div class='c-both'></div>
  </div>
  <?php include './side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
