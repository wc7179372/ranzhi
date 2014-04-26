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
  <?php echo $this->fetch('action', 'history', "objectType=order&objectID={$order->id}&customer={$order->customer}");?>
  <div class='text-center'>
    <?php 
    echo html::a($this->createLink('sys.action', 'createRecord', "objectType=order&objectID={$order->id}&customer={$order->customer}"), $lang->order->record, "class='btn' data-toggle='modal'");
    if(empty($order->contract))  echo html::a(helper::createLink('contract', 'create', "orderID=$order->id"), $this->lang->order->sign, "class='btn btn-default'");
    if(!empty($order->contract)) echo html::a('###', $this->lang->order->sign, "disabled='disabled' class='disabled'");

    echo html::a(inlink('assignTo', "orderID=$order->id"), $this->lang->assign, "data-toggle='modal' class='btn btn-default'");
    echo html::a(inlink('edit',     "orderID=$order->id"), $this->lang->edit,   "class='btn btn-default'");

    if($order->status != 'closed') echo html::a(inlink('close', "orderID=$order->id"), $this->lang->close, "class='btn btn-default' data-toggle='modal'");
    if($order->closedReason == 'payed') echo html::a('###', $this->lang->close, "disabled='disabled' class='disabled btn'");
    if($order->closedReason != 'payed' and $order->status == 'closed') echo html::a(inlink('activate', "orderID=$order->id"), $this->lang->activate, "class='btn reload btn-default'");

    echo html::a(inlink('delete', "orderID={$order->id}"), $lang->delete, "class='btn btn-default deleter'");
    echo html::backButton();
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
          <td><?php echo $customer->name . $lang->customer->levelList[$customer->level];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td><?php echo $product->name;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plan;?>
          <td><?php echo $order->plan;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->real;?>
          <td><?php echo $order->real;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->assignedTo;?></th>
          <td><?php echo $users[$order->assignedTo];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->status;?></th>
          <td><strong class='<?php echo $config->order->statusClassList[$order->status];?>'><?php echo $lang->order->statusList[$order->status];?></strong></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->closedReason;?></th>
          <td><strong><?php echo $lang->order->closedReasonList[$order->closedReason];?></strong></td>
        </tr>
      </table>
    </div>
  </div>
  <?php if($contract):?>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->contract->common;?></strong></div>
    <div class='panel-body'>
      <?php echo html::a($this->createLink('contract', 'view', "contractID={$contract->id}"), $contract->name);?>
    </div>
  </div>
  <?php endif;?>
  <div class='panel'>
    <div class='panel-heading'><h5><?php echo $lang->customer->contact;?></h5></div>
    <div class='panel-body'>
      <table class='table table-hover table-striped table-data table-contact'>
        <?php foreach($contacts as $contact):?>
        <tr>
          <td>
            <dl>
              <dt <?php if($contact->maker) echo "class='text-danger'";?>>
                <?php echo $contact->realname;?>
              </dt>
              <dd>
                <small class='w-70px'> <?php echo $lang->resume->dept . $lang->colon; ?></small>
                <strong><?php echo $contact->dept;?></strong>
                <small> <?php echo $lang->resume->title . $lang->colon; ?></small>
                <strong><?php echo $contact->title;?></strong>
              </dd>
              <?php foreach($config->contact->contactWayList as $item):?>
              <?php if(!empty($contact->{$item})):?>
              <dd>
                <small class='w-70px'><?php echo $lang->contact->{$item} . $lang->colon;?></small>
                <strong><?php echo $contact->{$item};?></strong>
              </dd>
              <?php endif;?>
              <?php endforeach;?>
            </dl>
          </td>
        </tr>
        <?php endforeach;?>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
