<?php
/**
 * The admin view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Hao Sun <catouse@me.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include "../../../sys/common/view/header.modal.html.php";?>
<?php js::set('index', $index);?>
<?php include "../../../sys/common/view/chosen.html.php";?>
<table class='table table-form' style="border:none;">
  <th class='w-100px'><?php echo $lang->block->lblBlock?></th>
  <td><?php echo html::select('blocks', $blocks, $blockID, "class='form-control'")?></td>
</table>
<?php if($params):?>
<form method='post' id='ajaxForm' action='<?php echo inlink('admin', "index=$index&blockID=$blockID")?>'>
  <table class='table table-form'>
    <tbody>
      <tr>
        <th class='w-100px'><?php echo $lang->block->name;?></th>
        <td>
          <?php
          echo html::input('title', $block ? $block->title : $blocks[$blockID], "class='form-control'");
          echo html::hidden('block', $blockID);
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
          $options = isset($param['options']) ? $param['options'] : array();
          if($control == 'select' or $control == 'radio' or $control == 'checkbox')
          {
              $chosen = $control == 'select' ? 'chosen' : '';
              if(strpos($attr, 'multiple') !== false)
              {
                  echo html::$control("params[$key][]", $options, $default, "class='form-control " . $chosen . "' $attr");
              }
              else
              {
                  echo html::$control("params[$key]", $options, $default, "class='form-control " . $chosen .  "' $attr");
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
      <tr><th></th><td><?php echo html::submitButton()?></td></tr>
    </tfoot>
  </table>
</form>
<?php endif;?>
<?php include "../../../sys/common/view/footer.modal.html.php";?>
