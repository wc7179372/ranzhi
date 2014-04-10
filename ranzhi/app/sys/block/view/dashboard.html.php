<?php
/**
 * The dashboard view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
if(isset($pageCSS)) css::internal($pageCSS);
?>
<div class='dashboard dashboard-draggable' id='dashboard'>
  <div class='row'>
    <?php foreach($blocks as $key => $block):?>
    <?php
    $index = str_replace('b', '', $key);
    $block = $block->value;
    ?>  
    <div class='col-sm-6 col-md-4'>
      <div class='panel' id='block<?php echo $index?>' data-id='<?php echo $index?>' data-name='<?php echo $block->name?>' data-url='<?php echo $block->blockLink?>'>
        <div class='panel-heading'>
          <?php echo $block->name?>
          <div class='panel-actions'>
            <button class='btn btn-mini refresh-panel'><i class='icon-repeat'></i></button>
            <div class='dropdown'>
              <button class='btn btn-mini' data-toggle='dropdown'><span class='caret'></span></button>
              <ul class='dropdown-menu pull-right'>
                <li><a data-toggle='modal' href="<?php echo $this->createLink("block", "admin", "index=$index"); ?>" class='edit-block window-btn' data-name='<?php echo $block->name; ?>' data-icon='icon-pencil'><i class='icon-pencil'></i> <?php echo $lang->edit; ?></a></li>
                <li><a href='javascript:;' class='remove-panel'><i class='icon-remove'></i> <?php echo $lang->close; ?></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class='panel-body no-padding'></div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <div class='dashboard-actions'><a class='btn btn-primary' href='<?php echo $this->createLink("block", "admin", "index=" . empty($index) ? 1 : ($index + 1)); ?>' data-toggle='modal'><i class='icon-plus'></i> <?php echo $lang->block->createBlock?></a></div>
</div>
<script>config.ordersSaved = '<?php echo $lang->block->ordersSaved; ?>';</script>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
if(isset($pageJS)) js::execute($pageJS);

/* Load hook files for current page. */
$extPath      = dirname(dirname(dirname(realpath($viewFile)))) . '/common/ext/view/';
$extHookRule  = $extPath . 'footer.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>