<?php
/**
 * The side common view file of blog module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
$treeMenu = $this->tree->getTreeMenu('blog', 0, array('treeModel', 'createBlogBrowseLink'));
?>
<div class='col-md-3'>
  <div class='box widget radius'> 
    <h4 class='title'><?php echo $lang->categoryMenu;?></h4>
    <?php echo $treeMenu;?>
  </div>
</div>