<?php
/**
 * The link front view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<?php if(!empty($this->config->links->index)):?>
<ul class='nav nav-pills' id='links'>
  <li class='nav-heading'><i class='icon-link'></i> <?php echo $this->lang->link; ?></li>
  <li><?php echo $this->config->links->index;?></li>
  <li><?php echo html::a(helper::createLink('links', 'index'), $this->lang->more . "<i class='icon-double-angle-right'></i>"); ?></li>
</ul>
<?php endif;?>