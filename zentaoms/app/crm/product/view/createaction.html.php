<?php 
/**
 * The create action view file of product module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php $title = "<i class='icon-edit'></i> " . $lang->product->action->create;?>
<?php include '../../common/view/header.modal.html.php'; ?>
<form method='post' action="<?php echo inlink('createaction', "productID={$productID}");?>" id='ajaxForm'>
  <table class='table table-form'>
    <tr>
      <th class='w-100px'><?php echo $lang->product->action->name;?></th>
      <td><?php echo html::input('name', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->action->action;?></th>
      <td><?php echo html::input('action', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php'; ?>

