<?php 
/**
 * The view file for the method of view of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php'; ?>
<div class='col-lg-8'>
  <?php echo $this->fetch('action', 'history', "objectType=order&objectID={$order->id}");?>
  <div class='page-actions'>
    <?php
    echo "<div class='btn-group'>";
    echo html::a($this->createLink('action', 'createRecord', "objectType=order&objectID={$order->id}&customer={$order->customer}"), $lang->order->record, "class='btn' data-toggle='modal'");
    if($order->status == 'normal') echo html::a(helper::createLink('contract', 'create', "customer={$order->customer}&orderID={$order->id}"), $lang->order->sign, "class='btn btn-default'");
    if($order->status != 'normal') echo html::a('###', $lang->order->sign, "class='btn' disabled='disabled' class='disabled'");
    if($order->status != 'closed')  echo html::a(inlink('assign', "orderID=$order->id"), $lang->assign, "data-toggle='modal' class='btn btn-default'");
    if($order->status == 'closed')  echo html::a('###', $lang->assign, "data-toggle='modal' class='btn btn-default disabled' disabled");
    echo '</div>';

    echo "<div class='btn-group'>";
    if($order->status != 'closed') echo html::a(inlink('close', "orderID=$order->id"), $lang->close, "class='btn btn-default' data-toggle='modal'");
    if($order->closedReason == 'payed') echo html::a('###', $lang->close, "disabled='disabled' class='disabled btn'");
    if($order->closedReason != 'payed' and $order->status == 'closed') echo html::a(inlink('activate', "orderID=$order->id"), $lang->activate, "class='btn' data-toggle='modal'");
    if($order->closedReason == 'payed' or  $order->status != 'closed') echo html::a('###', $lang->activate, "class='btn disabled' data-toggle='modal'");
    echo '</div>';

    echo "<div class='btn-group'>";
    echo html::a(inlink('edit',     "orderID=$order->id"), $lang->edit,   "class='btn btn-default'");
    echo '</div>';

    $browseLink = $this->session->orderList ? $this->session->orderList : inlink('browse');
    echo html::a($browseLink, $lang->goback, "class='btn btn-default'");
    ?>
  </div>
</div>
<div class='col-lg-4'>
  <div class='panel'>
    <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->order->basicInfo;?></strong></div>
    <div class='panel-body'>
      <?php $payed = $order->status == 'payed';?>
      <table class='table table-info'>
        <tr>
          <th class='w-80px'><?php echo $lang->order->customer;?></th>
          <td><?php echo html::a($this->createLink('customer', 'view', "customerID={$customer->id}"), $customer->name) . $lang->customer->levelNameList[$customer->level];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td><?php echo html::a($this->createLink('product', 'view', "productID={$product->id}"), $product->name);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->currency;?></th>
          <td><?php echo zget($currencyList, $order->currency, '');?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plan;?></th>
          <td><?php echo $order->plan;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->real;?></th>
          <td><?php echo $order->real;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->assignedTo;?></th>
          <td><?php echo zget($users, $order->assignedTo);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->status;?></th>
          <td><?php echo $lang->order->statusList[$order->status];?></td>
        </tr>
        <?php if($order->status == 'signed' and $contract):?>
        <tr>
          <th><?php echo $lang->contract->common;?></th>
          <td>
            <?php echo html::a($this->createLink('contract', 'view', "contractID={$contract->id}"), $contract->name);?>
          </td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->order->contactedDate;?></th>
          <td><?php echo $customer->contactedDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->nextDate;?></th>
          <td><?php echo $customer->nextDate;?></td>
        </tr>
      </table>
    </div>
  </div> 
  <?php echo $this->fetch('contact', 'block', "customer={$order->customer}");?>
  <div class='panel'>
    <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->order->lifetime;?></strong></div>
    <div class='panel-body'>
      <?php $payed = $order->status == 'payed';?>
      <table class='table table-info'>
        <tr>
          <th class='w-80px'><?php echo $lang->lifetime->createdBy;?></th>
          <td><?php echo zget($users, $order->createdBy) . $lang->at . $order->createdDate;?></td>
        </tr>
        <tr>
          <th class='w-80px'><?php echo $lang->lifetime->assignedTo;?></th>
          <td><?php if($order->assignedTo) echo zget($users, $order->assignedTo) . $lang->at . $order->assignedDate;?></td>
        </tr>
        <tr>
          <th class='w-80px'><?php echo $lang->lifetime->closedBy;?></th>
          <td><?php if($order->closedBy) echo zget($users, $order->closedBy) . $lang->at . $order->closedDate;?></td>
        </tr>
        <tr>
          <th class='w-80px'><?php echo $lang->lifetime->closedReason;?></th>
          <td><?php echo $lang->order->closedReasonList[$order->closedReason];?></td>
        </tr>
        <tr>
          <th class='w-80px'><?php echo $lang->lifetime->signedBy;?></th>
          <td>
            <?php if($contract and $contract->signedBy and $contract->status != 'canceled') echo zget($users, $contract->signedBy) . $lang->at . $contract->signedDate;?>
          </td>
        </tr>
        <tr>
          <th class='w-80px'><?php echo $lang->order->editedBy;?></th>
          <td><?php if($order->editedBy) echo zget($users, $order->editedBy) . $lang->at . $order->editedDate;?></td>
          <td>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
