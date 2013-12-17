<?php
/**
 * The browse view file of tree category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<?php 
js::set('root', $root);
js::set('book', $book);
js::set('type', $type);
?>
<?php if(strpos($treeMenu, '<li>') !== false):?>
<div class='row'>
  <div class='col-md-4'>
    <table class='table'>
      <caption><?php echo $title;?></caption>
      <tr>
        <td><div id='treeMenuBox'><?php echo $treeMenu;?></div></td>
      </tr>
    </table>
  </div>
  <div class='col-md-8' id='categoryBox'></div>
</div>
<?php else:?>
<div class='col-md-12' id='categoryBox'></div>
<?php endif;?>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/footer.admin.html.php';?>
