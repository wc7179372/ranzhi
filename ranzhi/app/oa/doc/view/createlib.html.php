<?php
/**
 * The createlib view file of doc module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     doc 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php'; ?>
<?php include '../../../crm/common/view/header.modal.html.php'; ?>
<form method='post' id='ajaxModalForm' action='<?php echo inlink('createLib')?>'>
  <div class='form-group'>
    <label for="name"><?php echo $lang->doc->libName;?></label>
    <?php echo html::input('name', '', "class='form-control'");?>
  </div>
  <?php echo html::submitButton();?>
</form>
<?php include '../../../crm/common/view/footer.modal.html.php'; ?>