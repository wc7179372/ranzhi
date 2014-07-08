<?php
/**
 * The en file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->block->common = 'Block';
$lang->block->name   = 'Name';

$lang->block->lblEntry = 'Entry';
$lang->block->lblBlock = 'Block';
$lang->block->lblRss   = 'RSS';
$lang->block->lblNum   = 'Number';
$lang->block->lblHtml  = 'HTML';

$lang->block->params = new stdclass();
$lang->block->params->name  = 'Name';
$lang->block->params->value = 'Value';

$lang->block->createBlock        = 'Create Block';
$lang->block->ordersSaved        = 'Sort have been saved';
$lang->block->confirmRemoveBlock = 'Are you sure remove block [{0}] ?';

$lang->block->default['oa']['1']['title'] = 'System Announcement';
$lang->block->default['oa']['1']['block'] = 'announce';
$lang->block->default['oa']['1']['grid']  = 3;

$lang->block->default['oa']['1']['params']['num'] = 15;

$lang->block->default['oa']['2']['title'] = 'The task of created by me';
$lang->block->default['oa']['2']['block'] = 'myCreatedTask';
$lang->block->default['oa']['2']['grid']  = 3;

$lang->block->default['oa']['2']['params']['num']     = 15;
$lang->block->default['oa']['2']['params']['orderBy'] = 'id_desc';
$lang->block->default['oa']['2']['params']['status']  = array();

$lang->block->default['oa']['3']['title'] = 'The task of assigned to me';
$lang->block->default['oa']['3']['block'] = 'assignedMeTask';
$lang->block->default['oa']['3']['grid']  = 3;

$lang->block->default['oa']['3']['params']['num']     = 15;
$lang->block->default['oa']['3']['params']['orderBy'] = 'id_desc';
$lang->block->default['oa']['3']['params']['status']  = array();

$lang->block->default['crm']['1']['title'] = 'My Order';
$lang->block->default['crm']['1']['block'] = 'order';
$lang->block->default['crm']['1']['grid']  = 3;

$lang->block->default['crm']['1']['params']['num']     = 15;
$lang->block->default['crm']['1']['params']['orderBy'] = 'id_desc';
$lang->block->default['crm']['1']['params']['status']  = array();

$lang->block->default['crm']['2']['title'] = 'My Contract';
$lang->block->default['crm']['2']['block'] = 'contract';
$lang->block->default['crm']['2']['grid']  = 3;

$lang->block->default['crm']['2']['params']['num']     = 15;
$lang->block->default['crm']['2']['params']['orderBy'] = 'id_desc';
$lang->block->default['crm']['2']['params']['status']  = array();

$lang->block->default['cash']['1']['title'] = 'Payment Depositor';
$lang->block->default['cash']['1']['block'] = 'depositor';
$lang->block->default['cash']['1']['grid']  = 3;

$lang->block->default['team']['1']['title'] = 'Latest Blog';
$lang->block->default['team']['1']['block'] = 'blog';
$lang->block->default['team']['1']['grid']  = 3;

$lang->block->default['team']['1']['params']['num'] = 15;

$lang->block->default['team']['2']['title'] = 'Latest Thread';
$lang->block->default['team']['2']['block'] = 'thread';
$lang->block->default['team']['2']['grid']  = 3;

$lang->block->default['team']['2']['params']['num'] = 15;

$lang->block->default['sys']['1'] = $lang->block->default['oa']['1'];
$lang->block->default['sys']['1']['source'] = 'oa';
$lang->block->default['sys']['2'] = $lang->block->default['crm']['2'];
$lang->block->default['sys']['2']['source'] = 'crm';
$lang->block->default['sys']['3'] = $lang->block->default['crm']['1'];
$lang->block->default['sys']['3']['source'] = 'crm';
$lang->block->default['sys']['4'] = $lang->block->default['cash']['1'];
$lang->block->default['sys']['4']['source'] = 'cash';
$lang->block->default['sys']['5'] = $lang->block->default['team']['1'];
$lang->block->default['sys']['5']['source'] = 'team';
$lang->block->default['sys']['6'] = $lang->block->default['team']['2'];
$lang->block->default['sys']['6']['source'] = 'team';
