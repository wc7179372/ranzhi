<?php
/**
 * The create view file of article module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php js::set('type', $type);?>
<?php js::set('categoryID', $currentCategory);?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-plus'></i>&nbsp;<?php echo $lang->{$type}->create;?></strong></div>
  <div class='panel-body'>
    <form method='post' role='form' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th style='width: 100px'><?php echo $lang->article->category;?></th>
          <td style="width: 40%"><?php echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='form-control chosen'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->article->title;?></th>
          <td colspan='2'><?php echo html::input('title', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->article->content;?></th>
          <td colspan='2'><?php echo html::textarea('content', '', "rows='20' class='form-control'");?></td>
        </tr>
        <tr>
          <td></td>
          <td colspan='2'><?php echo html::submitButton() . html::commonButton($lang->article->createDraft, "btn btn-default draft") . html::hidden('type', $type);?></td>
       </tr>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
