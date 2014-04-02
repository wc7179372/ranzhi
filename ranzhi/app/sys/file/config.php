<?php
/**
 * The config file of file module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->file->thumbs = array();
$config->file->thumbs['s'] = array('width' => '80',  'height' => '80');
$config->file->thumbs['m'] = array('width' => '300', 'height' => '300');
$config->file->thumbs['l'] = array('width' => '800', 'height' => '600');

$config->file->imageExtensions = array('jpeg', 'jpg', 'gif', 'png');