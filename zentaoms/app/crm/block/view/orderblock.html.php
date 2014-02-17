<table class='table'>
  <tr>
    <th class='w-id'><?php echo $lang->order->id?></th>
    <th><?php echo $lang->order->customer?></th>
    <th><?php echo $lang->order->product?></th>
    <th><?php echo $lang->order->status?></th>
    <th></th>
  </tr>
  <?php foreach($orders as $id => $order):?>
  <tr>
    <td><?php echo $id?></td>
    <td><?php echo $customers[$order->customer]?></td>
    <td><?php echo $products[$order->product]?></td>
    <td><?php echo $lang->order->statusList[$order->status]?></td>
    <td><?php echo html::a($this->createLink('order', 'view', "orderID=$id"), $this->lang->order->view)?></td>
  </tr>
  <?php endforeach;?>
</table>