<?php
/**
 * The reply view file of user module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='page-user-control'>
  <div class='row'>
    <?php include './side.html.php';?>
    <div class='col-md-10'>
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-mail-reply'></i> <?php echo $lang->user->reply;?></strong></div>
        <table class='table table-hover'>
          <thead>
            <tr class='text-center'>
              <th><?php echo $lang->thread->common;?></th>
              <th><?php echo $lang->reply->createdDate;?></th>
            </tr>  
          </thead>
          <tbody>
            <?php foreach($replies as $reply):?>
            <tr>
              <td><?php echo html::a($this->createLink('thread', 'view', "id=$reply->thread") . "#$reply->id", $reply->title . " <i>(#$reply->id)</i>", "target='_blank'");?></td>
              <td class='text-center'><?php echo substr($reply->createdDate, 2, -3);?></td>
            </tr>  
            <?php endforeach;?>
          </tbody>
          <tfoot><tr><td colspan='2'><?php $pager->show('right', 'short');?></td></tr></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
