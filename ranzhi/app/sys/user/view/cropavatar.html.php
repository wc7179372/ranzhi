<?php
/**
 * The crop avatar view file of user module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: profile.html.php 8669 2014-05-02 07:58:48Z guanxiying $
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<table class='table table-form'>
  <tr>
    <td>
      <div class="img-cutter fixed-ratio" id="imgCutter">
        <div class="canvas">
        <?php
        if(empty($user->avatar))
        {
            echo html::image($image->fullURL);
        }
        else
        {
            echo html::image($user->avatar);
        }
        ?>
        </div>
        <div class="actions">
          <h5><?php echo $lang->user->cropAvatarTip;?></h5>
          <div class="img-cutter-preview"></div>
          <button type="button" class="btn btn-primary img-cutter-submit"><?php echo $lang->save;?></button> <?php echo html::a(inlink('profile'), $lang->goback, "class='btn loadInModal'");?>
        </div>
      </div>
    </td>
  </tr>
</table>
<script>
$("#imgCutter").imgCutter(
{
    fixedRatio: true,
    post: '<?php echo inlink('cropavatar', "image={$image->id}")?>',
    ready: function() {$.ajustModalPosition();},
    done: function(response)
    {
        $('#start .avatar, #startMenu .avatar').html('<img src="<?php echo $user->avatar?>" />');
        $('#ajaxModal').load(createLink('user', 'profile'), function(){$.ajustModalPosition()});
    },
});
</script>
<?php include '../../common/view/footer.modal.html.php';?>
