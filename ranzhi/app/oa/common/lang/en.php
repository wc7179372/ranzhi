<?php
/**
 * The en file of common module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->app = new stdclass();
$lang->app->name = 'OA';

$lang->menu->oa = new stdclass();
$lang->menu->oa->dashboard = 'Dashboard|dashboard|index|';
$lang->menu->oa->task      = 'Task|task|index|';
$lang->menu->oa->announce  = 'Announce|announce|index|';
$lang->menu->oa->doc       = 'Doc|doc|index|';

$lang->dashboard = new stdclass();
$lang->block     = new stdclass();

$lang->announce = new stdclass();
$lang->announce->menu = new stdclass();
$lang->announce->menu->browse   = array('link' => 'Announce List|announce|browse|', 'alias' => 'view');
$lang->announce->menu->create   = 'Create Announce|article|create|type=announce|';
$lang->announce->menu->category = 'Category|tree|browse|type=announce|';

$lang->doc = new stdclass();
$lang->doc->menu = new stdclass();
$lang->doc->menu->create = 'Create Lib|doc|createLib|';