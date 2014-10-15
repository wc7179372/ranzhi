<?php
/**
 * The config file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$config->project = new stdclass();
$config->project->require = new stdclass();
$config->project->require->create = 'name';
$config->project->require->edit   = 'name';

$config->project->editor = new stdclass();
$config->project->editor->create = array('id' => 'desc', 'tools' => 'simple');
$config->project->editor->edit   = array('id' => 'desc', 'tools' => 'simple');
$config->project->editor->finish = array('id' => 'comment', 'tools' => 'simple');
