<script language='Javascript'>
var fold   = '<?php echo $lang->fold;?>';
var unfold = '<?php echo $lang->unfold;?>';
function switchChange(historyID)
{
    changeClass = $('#switchButton' + historyID).attr('class');
    if(changeClass.indexOf('change-show') > 0)
    {
        $('#switchButton' + historyID).attr('class', changeClass.replace('change-show', 'change-hide'));
        $('#changeBox' + historyID).show();
        $('#changeBox' + historyID).prev('.changeDiff').show();
    }
    else
    {
        $('#switchButton' + historyID).attr('class', changeClass.replace('change-hide', 'change-show'));
        $('#changeBox' + historyID).hide();
        $('#changeBox' + historyID).prev('.changeDiff').hide();
    }
}

function toggleStripTags(obj)
{
    var diffClass = $(obj).attr('class');
    if(diffClass.indexOf('diff-all') > 0)
    {
        $(obj).attr('class', diffClass.replace('diff-all', 'diff-short'));
        $(obj).attr('title', '<?php echo $lang->action->textDiff?>');
    }
    else
    {
        $(obj).attr('class', diffClass.replace('diff-short', 'diff-all'));
        $(obj).attr('title', '<?php echo $lang->action->original?>');
    }
    var boxObj  = $(obj).next();
    var oldDiff = '';
    var newDiff = '';
    $(boxObj).find('blockquote').each(function(){
        oldDiff = $(this).html();
        newDiff = $(this).next().html();
        $(this).html(newDiff);
        $(this).next().html(oldDiff);
    })
}

function toggleShow(obj)
{
    var orderClass = $(obj).find('span').attr('class');
    if(orderClass == 'change-show')
    {
        $(obj).find('span').attr('class', 'change-hide');
    }
    else
    {
        $(obj).find('span').attr('class', 'change-show');
    }
    $('.changes').each(function(){
        var box = $(this).parent();
        while($(box).get(0).tagName.toLowerCase() != 'li') box = $(box).parent();
        var switchButtonID = ($(box).find('span').find("span").attr('id'));
        switchChange(switchButtonID.replace('switchButton', ''));
    })
}

function toggleOrder(obj)
{
    var orderClass = $(obj).find('span').attr('class');
    if(orderClass == 'log-asc')
    {
        $(obj).find('span').attr('class', 'log-desc');
    }
    else
    {
        $(obj).find('span').attr('class', 'log-asc');
    }
    $("#historyItem li").reverseOrder();
}

function toggleComment(actionID)
{
    $('.comment' + actionID).toggle();
    $('#lastCommentBox').toggle();
    $('.ke-container').css('width', '100%');
}

$(function(){
    var diffButton = "<span onclick='toggleStripTags(this)' class='hidden changeDiff diff-all hand' title='<?php echo $lang->action->original?>'></span>";
    var newBoxID = ''
    var oldBoxID = ''
    $('blockquote').each(function(){
        newBoxID = $(this).parent().attr('id');
        if(newBoxID != oldBoxID) 
        {
            oldBoxID = newBoxID;
            if($(this).html() != $(this).next().html()) $(this).parent().before(diffButton);
        }
    })
})
</script>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<script src='<?php echo $jsRoot;?>jquery/reverseorder/raw.js' type='text/javascript'></script>

<?php if(!isset($actionTheme)) $actionTheme = 'fieldset';?>
<?php if($actionTheme == 'fieldset'):?>
<div id='actionbox'>
<fieldset>
  <legend>
  <?php echo $lang->history?>
    <span onclick='toggleOrder(this)' class='hand'> <?php echo "<span title='$lang->reverse' class='log-asc'></span>";?></span>
    <span onclick='toggleShow(this);' class='hand'><?php echo "<span title='$lang->switchDisplay' class='change-show'></span>";?></span>
  </legend>
<?php else:?>
<table class='table-1' id='actionbox'>
  <caption>
    <?php echo $lang->history?>
    <span onclick='$("#historyItem li").reverseOrder();' class='hand'> <?php echo "<span title='$lang->reverse' class='log-asc'></span>";?></span>
    <span onclick='toggleShow();' class='hand'><?php echo "<span title='$lang->switchDisplay' class='change-show'></span>";?></span>
  </caption>
  <tr><td>
<?php endif;?>

  <ol id='historyItem'>
    <?php $i = 1; ?>
    <?php foreach($actions as $action):?>
    <?php $canEditComment = (end($actions) == $action and $action->comment and $this->methodName == 'view' and $action->actor == $this->app->user->account);?>
    <li value='<?php echo $i ++;?>'>
      <?php
      if(isset($users[$action->actor])) $action->actor = $users[$action->actor];
      if($action->action == 'assigned' and isset($users[$action->extra]) ) $action->extra = $users[$action->extra];
      if(strpos($action->actor, ':') !== false) $action->actor = substr($action->actor, strpos($action->actor, ':') + 1);
      ?>
      <span>
        <?php $this->action->printAction($action);?>
        <?php if(!empty($action->history)) echo "<span id='switchButton$i' class='hand change-show' onclick=switchChange($i)></span>";?>
      </span>
      <?php if(!empty($action->comment) or !empty($action->history)):?>
      <?php if(!empty($action->comment)) echo "<div class='history'>";?>
        <div class='changes' id='changeBox<?php echo $i;?>' style='display:none;'>
        <?php echo $this->action->printChanges($action->objectType, $action->history);?>
        </div>
        <?php if($canEditComment):?>
        <span class='link-button f-right comment<?php echo $action->id;?>'><?php echo html::a('#lastCommentBox', '<i class="icon-edit-sign icon-large"></i>', '', "onclick='toggleComment($action->id)'")?></span>
        <?php endif;?>
        <?php 
        if($action->comment) 
        {
            echo "<div class='comment$action->id'>";
            echo strip_tags($action->comment) == $action->comment ? nl2br($action->comment) : $action->comment; 
            echo "</div>";
        }
        ?>
        <?php if($canEditComment):?>
        <div class='hidden' id='lastCommentBox'>
          <form method='post' action='<?php echo $this->createLink('action', 'editComment', "actionID=$action->id")?>'>
            <table align='center' class='table-1'>
              <tr><td><?php echo html::textarea('lastComment', $action->comment,"rows='5' class='w-p100'");?></td></tr>
              <tr><td><?php echo html::submitButton() . html::commonButton($lang->goback, "onclick='toggleComment($action->id)' class='button-b'");?></td></tr>
            </table>
          </form>
        </div>
        <?php endif;?>

        <?php if(!empty($action->comment)) echo "</div>";?>
      <?php endif;?>
    </li>
    <?php endforeach;?>
  </ol>

<?php if($actionTheme == 'fieldset'):?>
</fieldset>
<?php else:?>
</td></tr></table>
<?php endif;?>
</div>
