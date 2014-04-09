<?php
/**
 * The admin view file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Hao Sun <catouse@me.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include "../../../sys/common/view/header.modal.html.php";?>
<?php include "../../../sys/common/view/chosen.html.php";?>
<table class='table table-form' style="border:none;">
  <th class='w-100px'><?php echo $lang->block->lblBlock?></th>
  <td><?php echo html::select('blocks', $blocks, $blockID, "class='form-control'")?></td>
</table>
<?php if($params):?>
<form method='post' id='ajaxModalForm' action='<?php echo inlink('admin', "index=$index&blockID=$blockID")?>'>
  <table class='table table-form'>
    <tbody>
      <tr>
        <th class='w-100px'><?php echo $lang->block->name;?></th>
        <td>
          <?php
          echo html::input('name', $block ? $block->name : $blocks[$blockID], "class='form-control'");
          echo html::hidden('blockID', $blockID);
          ?>
        </td>
      </tr>
      <?php foreach($params as $key => $param):?>
      <tr>
        <th><?php echo $param['name']?></th>
        <td>
        <?php
          if(!isset($param['control'])) $param['control'] = 'input';
          if(!method_exists('html', $param['control'])) $param['control'] = 'input';

          $control = $param['control'];
          $attr    = empty($param['attr']) ? '' : $param['attr'];
          $default = $block ? (isset($block->params->$key) ? $block->params->$key : '') : (isset($param['default']) ? $param['default'] : '');
          $values  = isset($param['values']) ? $param['values'] : array();
          if($control == 'select' or $control == 'radio' or $control == 'checkbox')
          {
              $chosen = $control == 'select' ? 'chosen' : '';
              if(strpos($attr, 'multiple') !== false)
              {
                  echo html::$control("params[$key][]", $values, $default, "class='form-control " . $chosen . "' $attr");
              }
              else
              {
                  echo html::$control("params[$key]", $values, $default, "class='form-control " . $chosen .  "' $attr");
              }
          }
          else
          {
              echo html::$control("params[$key]", $default, "class='form-control' $attr");
          }
        ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr><td></td><td><?php echo html::submitButton()?></td></tr>
    </tfoot>
  </table>
</form>
<?php endif;?>
<script>
$(function()
{
    $('#blocks').change(function()
    {
        $('#ajaxModal').load(createLink('block', 'admin', "index=<?php echo $index?>&blockID=" + $(this).val()));
    });
})
</script>
<?php include "../../../sys/common/view/footer.modal.html.php";?>
