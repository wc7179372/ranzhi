<?php 
/**
 * The edit view file of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php'; ?>
<?php include '../../../sys/common/view/chosen.html.php'; ?>
<div class="col-lg-7">
  <div class='panel'>
    <div class='panel-heading'><i class='icon-pencil'></i> <?php echo $lang->order->edit;?></div>
    <div class='panel-body'>
      <form method='post' id='ajaxForm'>
        <table class='table table-form'>
          <tr>
            <th class='w-100px'><?php echo $lang->order->customer;?></th>
            <td><?php echo html::select('customer', $customers, $order->customer, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->order->product;?></th>
            <td><?php echo html::select('product', $products, $order->product, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->order->plan;?></th>
            <td><?php echo html::input('plan', $order->plan, "class='form-control'");?></td>
          </tr>
          <?php if($order->status == 'closed'):?>
          <tr>
            <th><?php echo $lang->order->closedReason;?></th>
            <td><?php echo html::select('closedReason', $lang->order->closedReasonList, $order->closedReason, "class='form-control'");?></td>
          </tr>
          <?php endif;?>
          <tr>
            <th></th>
            <td><?php echo html::submitButton() . html::hidden('referer', $this->server->http_referer);?></div>
          </div>
        </table>
      </form>
    </div>
  </div>
</div>
<div class="col-lg-5">
<?php echo $this->fetch('action', 'history', "objectType=order&objectID={$order->id}&customer={$order->customer}");?>
</div>
<?php include '../../common/view/footer.html.php';?>
