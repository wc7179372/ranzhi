<?php
/**
 * The datepicker view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id: chosen.html.php 7417 2013-12-23 07:51:50Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
include $this->app->getBasePath() . 'app/sys/common/view/datepicker.html.php';