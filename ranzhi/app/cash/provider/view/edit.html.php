<?php 
/**
 * The edit view file of provider module of RanZhi.
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
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-edit"></i> <?php echo $lang->customer->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form w-p60'>
        <tr>
          <th class='w-80px'><?php echo $lang->customer->name;?></th>
          <td class='w-p40'><?php echo html::input('name', $provider->name, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th class='w-80px'><?php echo $lang->customer->relation;?></th>
          <td class='w-p40'><?php echo html::select('relation', $lang->customer->relationList, $provider->relation, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->type;?></th>
          <td><?php echo html::select("type", $lang->customer->typeList, $provider->type, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->size;?></th>
          <td><?php echo html::select('size', $lang->customer->sizeList, $provider->size, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->industry;?></th>
          <td><?php echo html::select('industry', $industry, $provider->industry, "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->area;?></th>
          <td><?php echo html::select('area', $area,  $provider->area, "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->weibo;?></th>
          <td><?php echo html::input('weibo', $provider->weibo ? $provider->weibo : 'http://weibo.com/', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->weixin;?></th>
          <td><?php echo html::input('weixin', $provider->weixin, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->site;?></th>
          <td><?php echo html::input('site', $provider->site ? $provider->site : 'http://', "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->customer->desc;?></th>
          <td colspan='2'><?php echo html::textarea('desc', $provider->desc, "rows='2' class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
