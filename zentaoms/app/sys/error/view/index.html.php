<?php
/**
 * The error view file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     error
 * @version     $Id: index.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
include '../../common/view/header.html.php';
?>
<div class='alert alert-danger'>
  <h3><?php echo $lang->error->pageNotFound;?></h3>
  <p><?php echo $this->config->company->desc;?></p>
</div>
<?php $this->fetch('sitemap', 'index', 'onlyBody=yes')?>
<?php include '../../common/view/footer.html.php';?>
