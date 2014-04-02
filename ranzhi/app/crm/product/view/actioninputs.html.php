<?php 
/**
 * The action inputs view file of product module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->adminInputs;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <thead>
          <tr class='text-center'>
            <td><?php echo $lang->product->field->field;?></td>
            <td><?php echo $lang->product->field->rules;?></td>
            <td class='w-200px'><?php echo $lang->product->field->default;?></td>
            <td></td>
          </tr>
        </thead>
        <?php
        $i = 0;
        foreach($action->inputs as $field => $input):
        ?>
        <tr>
          <th><?php echo html::select("field[$i]", $inputFields, $field, "class='form-control'");?></th>
          <td><?php echo html::select("rules[$i][]", $lang->product->field->rulesList, $input->rules, "class='form-control chosen' multiple='multiple'"); ?></td>
          <td><?php echo html::input("default[$i]", $input->default, "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
        <?php $i++; endforeach;?>
        <?php js::set('key', $i)?>
        <tr><td colspan='4'><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
    <table class='hide'>
      <tr id='originTR'>
        <th><?php echo html::select('field[key]', $inputFields, '', "class='form-control'");?></th>
        <td><?php echo html::select('rules[key][]', $lang->product->field->rulesList, '', "class='form-control rules' multiple='multiple'"); ?></td>
        <td><?php echo html::input('default[key]', '', "class='form-control'")?></td>
        <td>
          <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
          <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
        </td>
      </tr>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>