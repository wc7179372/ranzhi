<?php
/**
 * The edit view of entry module of RanZhi.
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
    <strong><i class='icon-edit'></i> <?php echo $lang->entry->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' class='form form-inline' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->entry->name;?></th>
          <td class='w-p50'>
            <div class='input-group'>
              <?php echo html::input('name', $entry->name, "class='form-control' placeholder='{$lang->entry->note->name}'");?>
              <div class="input-group-addon"></div>
              <?php echo html::input('abbr', $entry->abbr, "class='form-control' size='2' maxlength='2' placeholder='{$lang->entry->note->abbr}'");?>
              <div class='input-group-addon'>
                <label class="checkbox"><input type="checkbox" id="visible" name="visible" value="1" <?php if($entry->visible) echo 'checked';?>> <?php echo $lang->entry->note->visible;?></label>
              </div>
            </div>
          </td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->logo;?></th>
          <td><?php echo html::file('files', "class='form-control'");?></td>
          <td colspan='2'><?php echo $lang->entry->note->logo;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->open;?></th>
          <td><?php echo html::select('open', $lang->entry->openList, $entry->open,'class="form-control"');?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->login;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('login', $entry->login, "class='form-control' placeholder='{$lang->entry->note->login}'");?>
              <div class='input-group-addon'>
                <label class="checkbox"><input type="checkbox" id="integration" name="integration" value="1" <?php if($entry->integration) echo 'checked';?>> <?php echo $lang->entry->integration;?></label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->logout;?></th>
          <td><?php echo html::input('logout', $entry->logout, "class='form-control' placeholder='{$lang->entry->note->logout}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->block;?></th>
          <td><?php echo html::input('block', $entry->block, "class='form-control' placeholder='{$lang->entry->note->api}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->key;?></th>
          <td><?php echo html::input('key', $entry->key, "class='form-control' readonly='readonly'");?></td>
          <td><?php echo html::a('javascript:void(0)', $lang->entry->createKey, 'onclick="createKey()"')?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->ip;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('ip', $entry->ip, "class='form-control' placeholder='{$lang->entry->note->ip}'");?>
              <div class='input-group-addon'>
                <label class="checkbox"><input type="checkbox" id="allip" name="allip" value="1"> <?php echo $lang->entry->note->allip;?></label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->control;?></th>
          <td><?php echo html::select('control', $lang->entry->controlList, $entry->control, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->size;?></th>
          <td><?php echo html::select('size', $lang->entry->sizeList, $entry->size, "class='form-control'");?></td>
          <td id='custom' class='w-200px'>
            <div class='input-group'>
              <div class='input-group-addon'><?php echo $lang->entry->width;?></div>
              <?php echo html::input('width', '700', "class='form-control'");?>
              <div class='input-group-addon'><?php echo $lang->entry->height;?></div>
              <?php echo html::input('height', '538', "class='form-control'");?>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->position;?></th>
          <td><?php echo html::select('position', $lang->entry->positionList, $entry->position, "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th><td><?php echo html::submitButton() . html::backButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
