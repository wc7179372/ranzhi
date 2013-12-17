<?php include '../../common/view/header.admin.html.php'; ?>
<table class='table table-hover table-bordered table-striped' id='threadList'>
  <caption><?php echo $lang->forum->threadList;?></caption>
  <thead>
    <tr class='a-center'>
      <th class='w-60px'><?php echo $lang->thread->id;?></th>
      <th class='w-60px'><?php echo $lang->thread->status;?></th>
      <th><?php echo $lang->thread->title;?></th>
      <th class='w-50px'><?php echo $lang->thread->author;?></th>
      <th class='w-100px'><?php echo $lang->thread->postedDate;?></th>
      <th class='w-60px'><?php echo $lang->thread->views;?></th>
      <th class='w-60px'><?php echo $lang->thread->replies;?></th>
      <th class='w-150px'><?php echo $lang->thread->lastReply;?></th>
      <th class='w-100px a-center'><?php echo $lang->actions;?></th>
    </tr>  
  </thead>
  <tbody>
    <?php foreach($threads as $thread):?>
    <tr class='a-center'>
      <td><?php echo $thread->id;?></td>
      <td><?php echo $thread->hidden ? $lang->thread->statusList['hidden'] : $lang->thread->statusList['normal'];?></td>
      <td class='a-left'>
        <?php
        $iconRoot = $themeRoot . 'default/images/forum/';
        echo $thread->isNew ? "<span class='new-board'>&nbsp;</span>" : "<span class='common-board'>&nbsp;</span>";
        echo html::a(commonModel::createFrontLink('thread', 'view', "threadID=$thread->id"), $thread->title, "target='_blank'");
        ?>
      </td>
      <td><?php echo $thread->author;?></td>
      <td><?php echo substr($thread->addedDate, 5, -3);?></td>
      <td><?php echo $thread->views;?></td>
      <td><?php echo $thread->replies;?></td>
      <td class='a-left'><?php if($thread->replies) echo substr($thread->repliedDate, 5, -3) . ' ' . $thread->repliedBy;?></td>  
      <td>
        <?php echo html::a($this->createLink('thread', 'delete', "threadID=$thread->id"), $lang->delete, "class='reload'"); ?>
        <?php 
        if($thread->hidden)
        {
            echo html::a($this->createLink('thread', 'show', "threadID=$thread->id"), $lang->thread->show, "class='reload'"); 
        }
        else
        {
            echo html::a($this->createLink('thread', 'hide', "threadID=$thread->id"), $lang->thread->hide, "class='reload'"); 
        }
        ?>
      </td>
    </tr>  
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='9'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php'; ?>
