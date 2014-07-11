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
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->schema->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form w-p40'>
        <tr>
          <th class='w-100px'><?php echo $lang->schema->name;?></th>
          <td><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->category;?></th>
          <td><?php echo html::input('category', '', "class='form-control' placeholder='{$lang->schema->placeholder->common}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->customer;?></th>
          <td><?php  echo html::input('customer', '', "class='form-control' placeholder='{$lang->schema->placeholder->common}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->money;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('money', '', "class='form-control' placeholder='{$lang->schema->placeholder->common}'");?>
              <div class='input-group-addon'><?php echo html::checkbox('diffCol', array(1 => $lang->schema->diffCol))?></div>
            </div>
          </td>
        </tr>
        <tr class='out'>
          <th><?php echo $lang->trade->typeList['out'];?></th>
          <td><?php  echo html::input('out', '', "class='form-control' placeholder='{$lang->schema->placeholder->out}'");?></td>
        </tr>
        <tr class='in'>
          <th><?php echo $lang->trade->typeList['in'];?></th>
          <td><?php  echo html::input('in', '', "class='form-control' placeholder='{$lang->schema->placeholder->in}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->type;?></th>
          <td><?php  echo html::input('type', '', "class='form-control' placeholder='{$lang->schema->placeholder->type}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->date;?></th>
          <td><?php echo html::input('date', '', "class='form-control' placeholder='{$lang->schema->placeholder->date}'");?></td>
        <tr>
          <th><?php echo $lang->trade->desc;?></th>
          <td><?php echo html::input('desc','', "class='form-control' placeholder='{$lang->schema->placeholder->desc}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->fee;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('fee','', "class='form-control' placeholder='{$lang->schema->placeholder->common}'");?>
              <div class='input-group-addon'><?php echo html::checkbox('feeRow', array(1 => $lang->schema->feeRow))?></div>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
