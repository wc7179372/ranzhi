<?php 
/**
 * The browse view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     trade 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->trade->browse;?></strong>
    <div class="panel-actions pull-right">
      <?php echo html::a(inlink('create', 'type=in'),  "{$lang->trade->createIn}</i>", "class='btn btn-primary'")?>
      <?php echo html::a(inlink('create', 'type=out'), "{$lang->trade->createOut}</i>", "class='btn btn-primary'")?>
      <?php echo html::a(inlink('transfer'), "{$lang->trade->transfer}</i>", "class='btn btn-primary'")?>
      <?php echo html::a(inlink('batchcreate'), "{$lang->trade->batchCreate}</i>", "class='btn btn-primary'")?>
      <?php echo html::a(inlink('import'), "{$lang->trade->import}</i>", "class='btn btn-primary' data-toggle='modal'")?>
    </div>
  </div>
  <form method='post' action='<?php echo inlink('batchedit', 'step=form')?>'>
    <table class='table table-hover table-striped tablesorter table-data' id='tradeList'>
      <thead>
        <tr class='text-center'>
          <th class='w-80px'><?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->trade->id);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('depositor', $orderBy, $vars, $lang->trade->depositor);?></th>
          <th class='w-60px'><?php commonModel::printOrderLink('type', $orderBy, $vars, $lang->trade->type);?></th>
          <th class='w-140px'><?php commonModel::printOrderLink('trader', $orderBy, $vars, $lang->trade->trader);?></th>
          <th class='w-120px'><?php commonModel::printOrderLink('money', $orderBy, $vars, $lang->trade->money);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('category', $orderBy, $vars, $lang->trade->category);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('handlers', $orderBy, $vars, $lang->trade->handlers);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('date', $orderBy, $vars, $lang->trade->date);?></th>
          <th><?php echo $lang->trade->desc;?></th>
          <th class='w-120px'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($trades as $trade):?>
        <tr class='text-center'>
          <td class='text-center'>
          <label class='checkbox-inline'><input type='checkbox' name='tradeIDList[]' value='<?php echo $trade->id;?>'/><?php echo $trade->id;?></label>
          </td>
          <td><?php echo $depositorList[$trade->depositor];?></td>
          <td><?php echo $lang->trade->typeList[$trade->type];?></td>
          <td><?php if($trade->trader) echo zget($customerList, $trade->trader);?></td>
          <td><?php echo zget($currencySign, $trade->currency) . $trade->money;?></td>
          <td><?php echo zget($categories, $trade->category, ' ');?></td>
          <td><?php foreach(explode(',', $trade->handlers) as $handler) echo zget($users, $handler) . ' ';?></td>
          <td><?php echo formatTime($trade->date, DT_DATE1);?></td>
          <td class='text-left'><?php echo $trade->desc;?></td>
          <td>
            <?php echo html::a(inlink('edit', "tradeID={$trade->id}"), $lang->edit);?>
            <?php echo html::a(inlink('detail', "tradeID={$trade->id}"), $lang->trade->detail, "data-toggle='modal'");?>
            <?php echo html::a(inlink('delete', "tradeID={$trade->id}"), $lang->delete, "class='deleter'");?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan='3'>
            <?php echo html::selectAll() . html::selectReverse() . html::submitButton($lang->edit);?>
          </td>
          <td colspan='8'>
            <?php echo $pager->get();?>
          </td>
        </tr>
      </tfoot>
    </table>
  </from>
</div>
<?php include '../../common/view/footer.html.php';?>
