  </div>
  <?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
  <div id='divider'></div>
<?php $onlybody = zget($_GET, 'onlybody', 'no');?>
<?php if($onlybody != 'yes'):?>
</div>
<div id='frontFooter'>
  <div id="crumbs">
    <?php commonModel::printBreadMenu($this->moduleName, isset($position) ? $position : ''); ?>
  </div>
  <div id="poweredby">
    <span>Powered by <a href='http://www.zentao.net' target='_blank'>ZenTaoMS</a> (<?php echo $config->version;?>)</span>
    <?php echo $lang->proVersion;?>
    <?php commonModel::printNotifyLink();?>
  </div>
</div>
<?php endif;?>
<?php 
js::set('onlybody', $onlybody);           // set the onlybody var.
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);  // load the js for current page.

/* Load hook files for current page. */
$extPath      = dirname(dirname(dirname(realpath($viewFile)))) . '/common/ext/view/';
$extHookRule  = $extPath . 'footer.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>
</body>
</html>