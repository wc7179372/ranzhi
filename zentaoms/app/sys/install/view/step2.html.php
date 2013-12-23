<?php
/**
 * The html template file of step2 method of install module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class="container"> 
<form method='post' action='<?php echo $this->createLink('install', 'step3');?>' class="form-inline" id="form1">
  <table class='table table-bordered shadow'>
    <caption><?php echo $lang->install->setConfig;?></caption>
    <tr>
      <th class='w-p20'><?php echo $lang->install->key;?></th>
      <th><?php echo $lang->install->value?></th>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbHost;?></th>
      <td><?php echo html::input('dbHost', '127.0.0.1');?><?php echo $lang->install->dbHostNote;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbPort;?></th>
      <td><?php echo html::input('dbPort', '3306');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbUser;?></th>
      <td><?php echo html::input('dbUser', 'root');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbPassword;?></th>
      <td><?php echo html::input('dbPassword');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbName;?></th>
      <td><?php echo html::input('dbName', 'zentaoms') . html::checkBox('clearDB', $lang->install->clearDB);?></td>
    </tr>
    <tr>
      <td colspan='2' class="a-center">
        <?php echo html::hidden('requestType','GET');?>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
</div>
<?php include './footer.html.php';?>
