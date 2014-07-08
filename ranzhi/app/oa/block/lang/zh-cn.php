<?php
/**
 * The zh-cn file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->block->announce = '系统公告';
$lang->block->lblBlock = '区块';
$lang->block->admin    = '管理区块';
$lang->block->type     = '类型';

$lang->block->availableBlocks = new stdclass();
$lang->block->availableBlocks->announce = '系统公告';
$lang->block->availableBlocks->task     = '任务列表';
$lang->block->availableBlocks->project  = '项目列表';

$lang->block->num     = '数量';
$lang->block->orderBy = '排序';
$lang->block->status  = '状态';
$lang->block->asc     = '正序';
$lang->block->desc    = '倒序';
$lang->block->actions = '操作';

$lang->block->orderByList = new stdclass();;
$lang->block->orderByList->task = array();
$lang->block->orderByList->task['id_asc']        = 'ID 递增';
$lang->block->orderByList->task['id_desc']       = 'ID 递减';
$lang->block->orderByList->task['pri_asc']       = '优先级递增';
$lang->block->orderByList->task['pri_desc']      = '优先级递减';
$lang->block->orderByList->task['deadline_asc']  = '截止日期递增';
$lang->block->orderByList->task['deadline_desc'] = '截止日期递减';

$lang->block->typeList['assignedTo'] = '指派给我';
$lang->block->typeList['createdBy']  = '由我创建';
$lang->block->typeList['finishedBy'] = '由我完成';
$lang->block->typeList['closedBy']   = '由我关闭';
$lang->block->typeList['canceledBy'] = '由我取消';
