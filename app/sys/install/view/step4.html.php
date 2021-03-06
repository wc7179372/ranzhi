<?php
/**
 * The html template file of step4 method of install module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
include '../../common/view/header.lite.html.php';
?>
<div class='container'>
  <div class='modal-dialog' style='width: 450px'>
    <form method='post' class='form-horizontal' id='adminForm'>
      <div class='modal-content'>
      <?php if(isset($error)):?>
        <div class='modal-header'><strong><?php echo $lang->install->error;?></strong></div>
        <div class='modal-body'>
          <div class='alert alert-danger'><?php echo $error;?></div>
        </div>
        <div class='modal-footer'><?php echo html::backButton($lang->install->pre, 'btn btn-primary');?></div>
      <?php else: ?>
        <div class='modal-header'><strong><i class='icon-key'></i> <?php echo $lang->install->setAdmin;?></strong></div>
        <div class='modal-body'>
          <div class='form-group'>
            <label for='account' class='col-xs-2 control-label'><?php echo $lang->install->account;?></label>
            <div class='col-xs-8'><?php echo html::input('account', '', "class='form-control'");?></div>
          </div>
          <div class='form-group'>
            <label for='password' class='col-xs-2 control-label'><?php echo $lang->install->password;?></label>
            <div class='col-xs-8'><?php echo html::input('password', '', "class='form-control' id='password1'");?></div>
          </div>
        </div>
        <div class='modal-footer'><?php echo html::submitButton();?></div>
      <?php endif; ?>
      </div>
    </form>
  </div>
</div>
<?php include './footer.html.php';?>
