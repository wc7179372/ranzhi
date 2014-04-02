<?php
/**
 * The link magange view file of tag of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan<guanxiying@xirangit.com>
 * @package     tag
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<div class='modal-dialog' style='width:600px;'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
      <h4 class='modal-title'><i class='icon-edit'></i> <?php echo $lang->tag->editLink;?></h4>
    </div>
    <div class='modal-body'>
      <form id='ajaxForm' class='form-horizontal' action='<?php echo inlink('link', "tageID={$tag->id}")?>'  method='post'>
        <div class='form-group'>
          <label for='link' class='col-xs-3 control-label'><?php echo $tag->tag;?></label>
          <div class='col-xs-8'>
            <?php echo html::input('link', $tag->link, "class='form-control' placeholder='{$lang->tag->inputLink}'");?>
          </div>
        </div>
        <div class='form-group'>
          <div class='col-xs-3'></div>
          <div class='col-xs-8'>
            <?php echo html::submitButton();?>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php if(isset($pageJS)) js::execute($pageJS);?>