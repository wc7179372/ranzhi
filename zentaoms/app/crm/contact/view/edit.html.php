<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->contact->edit;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->contact->realname;?></th>
          <td><?php echo html::input('realname', $contact->realname, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->nickname;?></th>
          <td><?php echo html::input('nickname', $contact->nickname, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->avatar;?></th>
          <td>
            <?php if($contact->avatar) echo html::image($contact->avatar, "width=60px"); ?>
            <?php echo html::file('avatar', "class='form-control'");?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->birthday;?></th>
          <td><?php echo html::input('birthday', $contact->birthday, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->gender;?></th>
          <td><?php echo html::radio('gender', $lang->contact->genderList, $contact->gender);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->email;?></th>
          <td><?php echo html::input('email', $contact->email, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->skype;?></th>
          <td><?php echo html::input('skype', $contact->skype, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->qq;?></th>
          <td><?php echo html::input('qq', $contact->qq, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->yahoo;?></th>
          <td><?php echo html::input('yahoo', $contact->yahoo, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->gtalk;?></th>
          <td><?php echo html::input('gtalk', $contact->gtalk, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->wangwang;?></th>
          <td><?php echo html::input('wangwang', $contact->wangwang, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->site;?></th>
          <td><?php echo html::input('site', $contact->site, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->mobile;?></th>
          <td><?php echo html::input('mobile', $contact->mobile, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->phone;?></th>
          <td><?php echo html::input('phone', $contact->phone, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->weibo;?></th>
          <td><?php echo html::input('weibo', $contact->weibo, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->weixin;?></th>
          <td><?php echo html::input('weixin', $contact->weixin, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->desc;?></th>
          <td><?php echo html::textarea('desc', $contact->desc, "rows='2' class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></div>
        </div>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>