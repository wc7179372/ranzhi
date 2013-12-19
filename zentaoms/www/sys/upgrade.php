<?php
/**
 * The upgrade router file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
/* Judge my.php exists or not. */
define('RUN_MODE', 'upgrade');
$myConfig = dirname(dirname(__FILE__)) . '/config/my.php';
if(!file_exists($myConfig))
{
    echo "文件" . $myConfig . "不存在！ 提示：不要重命名原来的禅道安装目录，下载最新的源码包，覆盖即可。" . "<br />";
    echo $myConfig . " doesn't exists! Please don't rename zentao before overriding the source code!";
    exit;
}

error_reporting(0);

/* Load the framework. */
include '../../framework/router.class.php';
include '../../framework/control.class.php';
include '../../framework/model.class.php';
include '../../framework/helper.class.php';

/* Instance the app. */
$app = router::createApp('sys');
$common = $app->loadCommon();

/* Reset the config params to make sure the install program will be lauched. */
$config->set('requestType', 'GET');
$config->set('default.module', 'upgrade');
$app->setDebug();

/* Check the installed version is the latest or not. */
$config->installedVersion = $common->loadModel('setting')->getVersion();
if(!$_SERVER['HTTP_X_REQUESTED_WITH'] and version_compare($config->version, $config->installedVersion) <= 0) die(header('location: ../index.php'));

/* Run it. */
$app->parseRequest();
$common->checkUpgradeStatus();
$app->loadModule();