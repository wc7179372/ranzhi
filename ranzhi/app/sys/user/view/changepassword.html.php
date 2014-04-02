<?php
/**
 * The changepassword view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<div class="modal-dialog" style="width:500px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><i class="icon-key"></i> <?php echo $lang->user->changePassword;?></h4>
    </div>
    <div class="modal-body">
      <form method='post' action='<?php echo inlink('changepassword');?>' id='passwordForm' class='form'>
        <table class='table table-form' style="border:none;">
          <tr>
            <th class="col-xs-4"><?php echo $lang->user->account;?></th>
            <td class="col-xs-6"><?php echo $user->account;?></td><td></td>
          </tr>  
          <tr>
            <th><?php echo $lang->user->newPassword;?></th>
            <td><?php echo html::password('password1', '', "class='form-control'");?></td><td></td>
          </tr>  
          <tr>
            <th><?php echo $lang->user->password2;?></th>
            <td><?php echo html::password('password2', '', "class='form-control'");?></td><td></td>
          </tr>  
          <tr><td></td><td><?php echo html::submitButton();?></td></tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php if(isset($pageJS)) js::execute($pageJS);?>