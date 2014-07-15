<?php
/**
 * The zh-cn file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->block->common = '区块';
$lang->block->name   = '区块名称';

$lang->block->lblEntry = '应用';
$lang->block->lblBlock = '区块';
$lang->block->lblRss   = 'RSS地址';
$lang->block->lblNum   = '条数';
$lang->block->lblHtml  = 'HTML内容';

$lang->block->params = new stdclass();
$lang->block->params->name  = '参数名称';
$lang->block->params->value = '参数值';

$lang->block->createBlock        = '添加区块';
$lang->block->ordersSaved        = '排序已保存';
$lang->block->confirmRemoveBlock = '确定移除区块【{0}】吗？';

$lang->block->default['oa']['1']['title'] = '系统公告';
$lang->block->default['oa']['1']['block'] = 'announce';
$lang->block->default['oa']['1']['grid']  = 3;

$lang->block->default['oa']['1']['params']['num'] = 15;

$lang->block->default['oa']['2']['title'] = '指派给我的任务';
$lang->block->default['oa']['2']['block'] = 'task';
$lang->block->default['oa']['2']['grid']  = 3;

$lang->block->default['oa']['2']['params']['num']     = 15;
$lang->block->default['oa']['2']['params']['orderBy'] = 'id_desc';
$lang->block->default['oa']['2']['params']['status']  = array();
$lang->block->default['oa']['2']['params']['type']    = 'assignedTo';

$lang->block->default['crm']['1']['title'] = '我的订单';
$lang->block->default['crm']['1']['block'] = 'order';
$lang->block->default['crm']['1']['grid']  = 3;

$lang->block->default['crm']['1']['params']['num']     = 15;
$lang->block->default['crm']['1']['params']['orderBy'] = 'id_desc';
$lang->block->default['crm']['1']['params']['status']  = array();

$lang->block->default['crm']['2']['title'] = '我的合同';
$lang->block->default['crm']['2']['block'] = 'contract';
$lang->block->default['crm']['2']['grid']  = 3;

$lang->block->default['crm']['2']['params']['num']     = 15;
$lang->block->default['crm']['2']['params']['orderBy'] = 'id_desc';
$lang->block->default['crm']['2']['params']['status']  = array();

$lang->block->default['cash']['1']['title'] = '付款账户';
$lang->block->default['cash']['1']['block'] = 'depositor';
$lang->block->default['cash']['1']['grid']  = 3;

$lang->block->default['cash']['1']['params'] = array();

$lang->block->default['team']['1']['title'] = '最新博客';
$lang->block->default['team']['1']['block'] = 'blog';
$lang->block->default['team']['1']['grid']  = 3;

$lang->block->default['team']['1']['params']['num'] = 15;

$lang->block->default['team']['2']['title'] = '最新帖子';
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
