<?php
/**
 * The setbasic view of company module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     company 
 * @version     $Id: setbasic.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form method='post' id='ajaxForm'>
  <table class='table table-form'>
    <caption><?php echo $lang->company->setBasic;?></caption> 
    <tr>
      <th class='w-100px'><?php echo $lang->company->name;?></th> 
      <td><?php echo html::input('name', isset($this->config->company->name) ? $this->config->company->name : '', "class='text-1'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->desc;?></th> 
      <td><?php echo html::textarea('desc',  isset($this->config->company->desc) ? $this->config->company->desc : '', "class='area-1' rows='5'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->content;?></th> 
      <td><?php echo html::textarea('content',  isset($this->config->company->content) ? $this->config->company->content : '', "class='area-1' rows='15'");?></td> 
    </tr>
    <tr>
      <th></th>
      <td>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
