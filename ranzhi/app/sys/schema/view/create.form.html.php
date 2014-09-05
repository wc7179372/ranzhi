<?php 
/**
 * The create view file of schema module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     schema 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include dirname($app->getAppRoot()) . '/sys/common/view/chosen.html.php';?>
<form method='post' id='ajaxForm'>
<div id='recordBox' class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->schema->create;?></strong>
  </div>
  <div class='panel-body'>
    <table class="table table-form">
      <tr>
        <td class='w-300px'>
          <div class='input-group'>
            <span class='input-group-addon'><?php echo $lang->schema->name;?></span>
            <?php echo html::input('name', $file['title'], "class='form-control'");?>
          </div>
        </td>
        <td><?php echo html::submitButton()?></td>
      </tr>
    </table>
    <div id='recordTable'>
      <table class='table table-data'>
        <thead>
          <tr>
            <?php for($i = 0; $i < $columns; $i ++):?>
            <th><?php echo html::select('schema[' . chr($i + 65) . '][]', $lang->trade->importedFields, '', "class='form-control chosen' multiple data-placeholder='{$lang->schema->placeholder->selectField}'");?></th>
            <?php endfor;?>
          </tr>
        </thead>
        <tbody>
          <?php foreach($records as $row => $values):?>
          <?php if($row > 10) break;?>
          <tr>
            <?php foreach($values as $key => $value):?>
            <td><nobr><?php echo $value;?></nobr></td>
            <?php endforeach;?>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</form>
<?php include '../../common/view/footer.html.php';?>
