<?php
/**
 * The config file of entry module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$config->entry = new stdclass();
$config->entry->require = new stdclass();
$config->entry->require->create = 'name,code,open,key,login';
$config->entry->require->edit   = 'name,open,key,login';
