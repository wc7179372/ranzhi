<?php
/**
 * The edit view file of feedback module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->feedback->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->feedback->product?></th>
          <td><?php echo html::select('product', $products, $issue->product, "class='form-control chosen'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->customer?></th>
          <td><?php echo html::select('customer', $customers, $issue->customer, "class='form-control chosen'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->contact?></th>
          <td><?php echo html::select('contact', $contacts, $issue->contact, "class='form-control chosen'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->title?></th>
          <td><?php echo html::input('title', $issue->title, "class='form-control'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->desc?></th>
          <td><?php echo html::textarea('desc', $issue->desc, "class='form-control'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->pri?></th>
          <td><?php echo html::select('pri', $lang->feedback->priList, $issue->pri, "class='form-control'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->assignedTo?></th>
          <td><?php echo html::select('assignedTo', $users, $issue->assignedTo, "class='form-control chosen'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->status?></th>
          <td><?php echo html::select('status', $lang->feedback->statusList, $issue->status, "class='form-control'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->feedback->closedReason?></th>
          <td><?php echo html::select('closedReason', $lang->feedback->closedReasonList, $issue->closedReason, "class='form-control'")?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton()?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
