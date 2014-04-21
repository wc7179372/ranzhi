<?php
/**
 * The view file of browse function of address module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     address
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<table class='table table-hover table-bordered'>
<caption>
<div class='pull-right'><?php echo html::a(inlink('create', "objectType=$objectType&objectID=$objectID"), $lang->address->create, "class='loadInModal'")?></div>
</caption>
  <tr class='text-center'>
    <th class='w-150px'><?php echo $lang->address->title;?></th>
    <th><?php echo $lang->address->location;?></th>
    <th class='w-100px'><?php echo $lang->actions;?></th>
  </tr>
  <?php foreach($addresses as $address):?>
  <tr>
    <td><?php echo $address->title?></td>
    <td><?php echo $address->country . ' ' . $address->province . ' ' . $address->city . ' ' . $address->location;?></td>
    <td>
      <?php
      if($address->objectType == $objectType and $address->objectID == $objectID)
      {
          echo html::a(inlink('edit', "id=$address->id"), $lang->edit, "class='loadInModal'");
          echo html::a(inlink('delete', "id=$address->id"), $lang->delete, "class='deleter'");
      }
      ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<?php include '../../../sys/common/view/footer.modal.html.php';?>