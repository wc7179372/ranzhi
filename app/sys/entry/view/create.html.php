<?php
/**
 * The create view of entry module of RanZhi.
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
    <strong><i class='icon-building'></i> <?php echo $lang->entry->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' class='form-inline' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->entry->name;?></th>
          <td class='w-p50'>
            <div class='input-group'>
              <?php echo html::input('name', '', "class='form-control' placeholder='{$lang->entry->note->name}'");?>
              <label class="input-group-addon"><?php echo $lang->entry->abbr;?></label>
              <?php echo html::input('abbr', '', "class='form-control' maxlength='2' placeholder='{$lang->entry->note->abbr}'");?>
              <div class='input-group-addon'>
                <label class="checkbox"><input type="checkbox" id="visible" name="visible" value="1"> <?php echo $lang->entry->note->visible;?></label>
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
          <th><?php echo $lang->entry->code;?></th>
          <td><?php echo html::input('code', '', "class='form-control' placeholder='{$lang->entry->note->code}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->open;?></th>
          <td><?php echo html::select('open', $lang->entry->openList, '', 'class="form-control"');?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->login;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('login', '', "class='form-control' placeholder='{$lang->entry->note->login}'");?>
              <div class='input-group-addon'>
                <label class="checkbox"><input type="checkbox" id="integration" name="integration" value="1"> <?php echo $lang->entry->integration;?></label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->logout;?></th>
          <td><?php echo html::input('logout', '', "class='form-control' placeholder='{$lang->entry->note->logout}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->block;?></th>
          <td><?php echo html::input('block', '', "class='form-control' placeholder='{$lang->entry->note->api}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->key;?></th>
          <td><?php echo html::input('key', $key, "class='form-control' readonly='readonly'");?></td>
          <td><span class="help-inline"><?php echo html::a('javascript:void(0)', $lang->entry->createKey, 'onclick="createKey()"')?></span></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->ip;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('ip', '', "class='form-control' placeholder='{$lang->entry->note->ip}'");?>
              <div class='input-group-addon'>
                <label class="checkbox"><input type="checkbox" id="allip" name="allip" value="1"> <?php echo $lang->entry->note->allip;?></label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->control;?></th>
          <td><?php echo html::select('control', $lang->entry->controlList, 'simple', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->entry->size;?></th>
          <td><?php echo html::select('size', $lang->entry->sizeList, '', "class='form-control'");?></td>
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
          <td><?php echo html::select('position', $lang->entry->positionList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th><td><?php echo html::submitButton() . html::backButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
