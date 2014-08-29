<?php
/**
 * The contract block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<table class='table table-data table-hover block-contract table-fixed'>
  <tr>
    <th><?php echo $lang->contract->name?></th>
    <th class='w-70px'><?php echo $lang->contract->amount?></th>
    <th class='w-60px'><?php echo $lang->contract->delivery?></th>
    <th class='w-60px'><?php echo $lang->contract->return?></th>
  </tr>
  <?php foreach($contracts as $id => $contract):?>
  <?php $appid = ($this->get->app == 'sys' and isset($_GET['entry'])) ? "class='app-btn' data-id='{$this->get->entry}'" : ''?>
  <tr data-url='<?php echo $this->createLink('crm.contract', 'view', "id=$id");?>' <?php echo $appid;?>>
    <td class='nobr'><?php echo $contract->name;?></td>
    <td class='text-danger'><?php echo $contract->amount?></td>
    <td><?php echo $lang->contract->deliveryList[$contract->delivery]?></td>
    <td><?php echo $lang->contract->returnList[$contract->return]?></td>
  </tr>
  <?php endforeach;?>
</table>
<script>if(!$.ipsStart) $('.block-contract').dataTable();</script>
