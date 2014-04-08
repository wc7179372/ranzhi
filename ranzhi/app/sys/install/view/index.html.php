<?php
/**
 * The html template file of index method of install module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-body'>
        <div class='row'>
          <div class='col-md-8'>
            <h3><?php echo $lang->install->welcome;?></h3>
            <div><?php printf(nl2br(trim($lang->install->desc)), $config->version);?></div>
          </div>
          <div class='col-md-4'>
            <div id='ranzhi'><?php echo html::image($themeRoot . '/default/images/ips/app-ranzhi.png');?></div>
          </div>
        </div>
      </div>
      <?php if(!isset($latestRelease)):?>
      <div class='modal-footer'>
        <p class='a-center'><?php echo html::a($this->createLink('install', 'step1'), $lang->install->start, "class='btn btn-primary'");?></p>
        <?php else:?>
        <?php vprintf($lang->install->newReleased, $latestRelease);?>
        <p>
          <?php 
          echo $lang->install->choice;
          echo html::a($latestRelease->url, $lang->install->seeLatestRelease, "target='_blank'");
          echo html::a($this->createLink('install', 'step1'), $lang->install->keepInstalling, "class='btn btn-primary'");
          ?>
        </p>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<?php include './footer.html.php';?>
