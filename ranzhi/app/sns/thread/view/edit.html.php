<?php
/**
 * The edit view file of thread module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php $common->printPositionBar($board, $thread);?>

<div class="panel">
  <div class="panel-heading"><strong><i class="icon-edit"></i> <?php echo $lang->thread->edit . $lang->colon . $thread->title;?></strong></div>
  <div class="panel-body">
    <form method='post' class='form-horizontal' id='editForm' enctype='multipart/form-data'>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->title;?></label>
        <div class='col-md-9 col-sm-8'><?php echo html::input('title', $thread->title, "class='form-control'");?></div>
        <?php $readonly = $thread->readonly ? 'checked' : ''; if($canManage): ?>
        <div class='col-md-2 col-sm-2'>
          <div class='checkbox'>
              <label>
                <?php echo "<input type='checkbox' name='readonly' value='1' $readonly/><span>{$lang->thread->readonly}</span>" ?>
              </label>
          </div>
          <?php  ?>
        </div>
        <?php endif; ?>
      </div>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->content;?></label>
        <div class='col-md-11 col-sm-10'><?php echo html::textarea('content', htmlspecialchars($thread->content), "rows='15' class='form-control'");?></div>
      </div>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->file;?></label>
        <div class='col-md-7 col-sm-8 col-xs-11'>
          <?php
          $this->thread->printFiles($thread, $canManage = true);
          echo $this->fetch('file', 'buildForm');
          ?>
        </div>
      </div>
      <div class='form-group' id='captchaBox' style='display:none'></div>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2'></label>
        <div class='col-md-11 col-sm-10'><?php echo html::submitButton() . html::backButton();;?></div>
      </div>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
