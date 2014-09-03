<?php 
/**
 * The browse view file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('status', $status);?>
<?php foreach($projects as $project):?>
<div class='col-md-4 col-sm-6'>
  <div class='panel project-block'>
    <div class='panel-heading'>
      <strong><?php echo $project->name;?></strong>
      <div class="panel-actions pull-right">
        <div class="dropdown">
          <button class="btn btn-mini" data-toggle="dropdown"><span class="caret"></span></button>
          <ul class="dropdown-menu pull-right">
            <?php echo '<li>' . html::a(inlink('edit', "projectID=$project->id"), $lang->edit, "data-toggle='modal'") . '</li>';?>
            <?php if($project->status != 'finished') echo '<li>' . html::a(inlink('finish', "projectID=$project->id"), $lang->finish, "data-toggle='modal'") . '</li>';?>
            <?php if($project->status != 'doing') echo '<li>' . html::a(inlink('activate', "projectID=$project->id"), $lang->activate, "class='switcher'") . '</li>';?>
            <?php if($project->status != 'suspend') echo '<li>' . html::a(inlink('suspend', "projectID=$project->id"), $lang->project->suspend, "class='switcher'") . '</li>';?>
          </ul>
        </div>
      </div>
    </div>
    <div class='panel-body'>
      <p class='info'><?php echo $project->desc;?></p>
      <p class='text-important'> <i class='icon icon-time'> </i><?php echo formatTime($project->begin) . ' ~ ' .  formatTime($project->end);?> </p>
      <p class='text-important'>
        <?php if(!empty($project->members)):?>
        <i class='icon icon-group'> </i>
        <?php foreach($project->members as $member) echo "<span class='{$member->role}'>{$users[$member->account]}</span>";?>
        <?php endif;?>
      </p>
      <?php echo html::a(helper::createLink('task', 'browse', "projectID=$project->id"), $lang->project->enter, "class='btn btn-primary btn-xs entry'");?>
    </div>
  </div>
</div>
<?php endforeach;?>
<?php include '../../common/view/footer.html.php';?>
