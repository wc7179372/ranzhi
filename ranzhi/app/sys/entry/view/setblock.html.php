<?php
/**
 * The admin view of entry module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id: admin.html.php 7488 2013-12-26 07:26:10Z zhujinyong $
 * @link        http://www.zentao.net
 */
?>
<?php
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
include "../../common/view/chosen.html.php";
?>
<form method='post' id='ajaxForm' class='form form-horizontal' action='<?php echo $this->createLink('block', 'set', "index=$index&type=$type")?>'>
  <table class='table table-form w-p80'>
    <tbody>
      <tr class='a-left'>
        <th class='w-100px'><?php echo $lang->block->name;?></th>
        <td>
        <?php
        echo html::input('name', isset($block->name) ? $block->name : '', "class='form-control'");
        echo html::hidden('blockID', $blockID) . html::hidden('entryID', $entryID);
        ?>
        </td>
      <?php foreach($params as $key => $param):?>
      <tr class='a-left'>
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
                  echo html::$control("params[$key]", $values, $default, "class='form-control " . $chosen . "' $attr");
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
<?php if(!isset($block->name)):?>
<script>$(function(){$('#name').val($('#entryBlock').find("option:selected").text());})</script>
<?php endif;?>