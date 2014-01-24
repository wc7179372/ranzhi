<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->adminConditions;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='text-center'><?php echo $lang->product->field->field;?></th>
          <th class='text-center'><?php echo $lang->product->action->conditions;?></th>
          <th class='text-center'><?php echo $lang->product->action->value;?></th>
        </tr>
        <?php
        $i = 0;
        foreach($action->conditions as $field => $condition):
        ?>
        <tr>
          <th><?php echo html::select('field[]', $conditionFields, $field, "class='form-control'");?></th>
          <td><?php echo html::select("operater[]", $lang->order->operaterList, $condition->operater, "class='form-control'"); ?></td>
          <td><?php echo html::input("value[]", $condition->value, "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
        <?php $i++; endforeach;?>
        <?php js::set('key', $i);?>
        <tr id='originTR'>
          <th><?php echo html::select('field[]', $conditionFields, '', "class='form-control'");?></th>
          <td><?php echo html::select("operater[]", $lang->order->operaterList, '', "class='form-control'"); ?></td>
          <td><?php echo html::input("value[]", '', "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
        <tr>
          <td colspan='3'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>