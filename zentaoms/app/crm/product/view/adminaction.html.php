<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->product->action->admin;?></strong>
  <div class='panel-actions'>
    <?php echo html::a($this->inlink('createAction', "productID={$productID}"), '<i class="icon-plus"></i> ' . $lang->product->action->create, 'class="btn btn-primary"');?>
  </div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->product->action->action;?></th>
        <th><?php echo $lang->product->action->name;?></th>
        <th style='width: 160px'><?php echo $lang->product->action->control;?></th>
        <th ><?php echo $lang->product->action->options;?></th>
        <th ><?php echo $lang->product->action->default;?></th>
        <th style='width: 200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($actions as $action):?>
      <tr class='text-center'>
        <td class='text-left'><?php echo $action->action;?></td>
        <td class='text-left'><?php echo $action->name;?></td>
        <td><?php echo $lang->product->action->controlTypeList[$action->control];?></td>
        <td><?php echo $action->options;?></td>
        <td><?php echo $action->default;?></td>
        <td>
          <?php
          echo html::a($this->createLink('product', 'actionConditions', "actionID=$action->id"), $lang->product->action->conditions);
          echo html::a($this->createLink('product', 'actionInputs', "actionID=$action->id"), $lang->product->action->inputs);
          echo html::a($this->createLink('product', 'actionTasks', "actionID=$action->id"), $lang->product->action->tasks);
          echo html::a($this->createLink('product', 'delete', "actionID=$action->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>