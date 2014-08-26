<?php 
/**
 * The browse view file of provider module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     provider 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->provider->list;?></strong>
  <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->provider->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->provider->id);?></th>
        <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->provider->name);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('size',        $orderBy, $vars, $lang->provider->size);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('type',        $orderBy, $vars, $lang->provider->type);?></th>
        <th class='w-160px'> <?php commonModel::printOrderLink('area',        $orderBy, $vars, $lang->provider->area);?></th>
        <th class='w-150px'> <?php commonModel::printOrderLink('industry',    $orderBy, $vars, $lang->provider->industry);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->provider->createdDate);?></th>
        <th class='w-110px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($providers as $provider):?>
      <tr class='text-center' data-url='<?php echo $this->createLink('provider', 'view', "providerID=$provider->id"); ?>'>
        <td><?php echo $provider->id;?></td>
        <td class='text-left'><?php echo $provider->name;?></td>
        <td><?php echo $lang->provider->sizeList[$provider->size];?></td>
        <td><?php echo $lang->provider->typeList[$provider->type];?></td>
        <td><?php if($provider->area) echo $area[$provider->area];?></td>
        <td><?php if($provider->industry) echo $industry[$provider->industry];?></td>
        <td><?php echo substr($provider->createdDate, 0, 10);?></td>
        <td class='actions'>
          <?php echo html::a(inlink('contact', "providerID=$provider->id"), $lang->provider->contact, "data-toggle='modal'");?>
          <?php echo html::a(inlink('edit',    "providerID=$provider->id"), $lang->edit);?>
          <?php echo html::a(inlink('delete',  "providerID=$provider->id"), $lang->delete, "class='deleter'");?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
