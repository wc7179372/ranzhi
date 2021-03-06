<?php
/**
 * The admin view of entry module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
include '../../common/view/header.html.php';
?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-building'></i> <?php echo $lang->entry->admin;?></strong>
    <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create'), $lang->entry->create, "class='btn btn-primary'");?></div>
  </div>
  <form action='<?php echo inlink('order')?>' method='post' id='ajaxForm'>
  <table class='table table-bordered table-hover table-striped'>
    <thead>
      <tr class='text-center'>
        <th class='w-70px'></th>
        <th class='w-100px'><?php echo $lang->entry->name;?></th>
        <th class='w-80px'><?php echo $lang->entry->code;?></th>
        <th class='w-300px'><?php echo $lang->entry->key;?></th>
        <th><?php echo $lang->entry->ip;?></th>
        <th class='w-100px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($entries as $entry):?>
      <tr class='text-left'>
        <td><?php echo html::input("order[$entry->id]", $entry->order, "class='form-control text-center'")?></td>
        <td><?php echo "<img src='$entry->logo' class='small-icon'>" . $entry->name?></td>
        <td><?php echo $entry->code?></td>
        <td><?php if($entry->integration) echo $entry->key?></td>
        <td class='text-center'><?php echo $entry->ip?></td>
        <td class='text-center'>
          <?php
          if(!$entry->buildin)
          {
              echo html::a($this->createLink('entry', 'edit',   "code=$entry->code"), $lang->edit);
              echo html::a($this->createLink('entry', 'delete', "code=$entry->code"), $lang->delete, 'class="deleter"');
          }
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr><td colspan="5"><?php echo html::submitButton($lang->entry->order);?></td></tr>
    </tfoot>
    <?php if(empty($entries)):?>
    <tfoot>
      <tr><td colspan="5"><div style="float:right; clear:none;" class="page"><?php echo $lang->entry->nothing?></div></td></tr>
    </tfoot>
    <?php endif;?>
  </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
