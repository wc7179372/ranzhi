<?php
/**
 * The lang view file of setting module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     setting
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <form method='post' id='ajaxForm'>
    <table class='table'>
      <tr>
        <th class='w-100px'><?php echo $lang->setting->key;?></th>
        <th><?php echo $lang->setting->value;?></th>
        <th class='w-100px'></th>
      </tr>
      <?php foreach($fieldList as $key => $value):?>
      <tr class='text-center'>
        <?php $system = isset($systemField[$key]) ? $systemField[$key] : 1;?>
        <td><?php echo $key === '' ? 'NULL' : $key; echo html::hidden('keys[]', $key) . html::hidden('systems[]', $system);?></td>
        <td>
          <?php $readonly = ($module == 'product' and $field == 'statusList' and $system == 1) ? 'readonly' : ''; ?>
          <?php echo html::input("values[]", $value, "class='form-control' $readonly");?>
        </td>
        <td class='text-left'>
          <a href='javascript:;' class='link-icon add'><i class='icon-plus'></i></a>
          <?php if(!$system):?><a href='javascript:;' class='link-icon remove'><i class='icon-remove'></i></a><?php endif;?>
        </td>
      </tr>
      <?php endforeach;?>
      <tfoot>
        <tr>
          <td colspan='3' class='text-center'>
          <?php 
          $appliedTo = array($clientLang => $lang->setting->currentLang, 'all' => $lang->setting->allLang);
          echo html::radio('lang', $appliedTo, 'all');
          echo html::submitButton();
          echo html::a(inlink('reset', "module=$module&field=$field"), $lang->setting->reset, "class='btn deleter'");
          ?>
          </td>
        </tr>
      <tfoot>
    </table>
  </form>
</div>
<?php
$itemRow = <<<EOT
  <tr class='a-center'>
    <td>
      <input type='text' value="" name="keys[]" class='form-control'>
      <input type='hidden' value="0" name="systems[]">
    </td>
    <td>
      <input type='text' value="" name="values[]" class='form-control'>
    </td>
    <td class='text-left'>
      <a href='javascript:;' class='link-icon add'><i class='icon-plus'></i></a>
      <a href='javascript:;' class='link-icon remove'><i class='icon-remove'></i></a>
    </td>
  </tr>
EOT;
?>
<?php js::set('itemRow', $itemRow)?>
<?php js::set('module', $module)?>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>