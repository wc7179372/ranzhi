<?php
/**
 * The zh-tw file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->task->common = '任務';
$lang->task->list   = '任務列表';

$lang->task->browse   = '瀏覽任務';
$lang->task->view     = '查看任務';
$lang->task->create   = '新建任務';
$lang->task->edit     = '編輯任務';
$lang->task->finish   = '任務完成';
$lang->task->start    = '開始任務';
$lang->task->activate = '激活任務';
$lang->task->cancel   = '取消任務';
$lang->task->close    = '關閉任務';
$lang->task->assignTo = '指派任務';
$lang->task->delete   = '刪除任務';

$lang->task->batchCreate = '批量添加';

$lang->task->id             = '編號';
$lang->task->project        = '所屬項目';
$lang->task->customer       = '所屬客戶';
$lang->task->order          = '相關訂單';
$lang->task->category       = '所屬模組';
$lang->task->name           = '名稱';
$lang->task->type           = '任務類型';
$lang->task->pri            = '優先順序';
$lang->task->estimate       = '最初預計';
$lang->task->estimateAB     = '預計';
$lang->task->consumed       = '總消耗';
$lang->task->consumedAB     = '消耗';
$lang->task->left           = '預計剩餘';
$lang->task->leftAB         = '剩';
$lang->task->deadline       = '截止日期';
$lang->task->deadlineAB     = '截止';
$lang->task->status         = '任務狀態';
$lang->task->statusAB       = '狀態';
$lang->task->statusCustom   = '狀態排序';
$lang->task->mailto         = '抄送給';
$lang->task->desc           = '任務描述';
$lang->task->createdBy      = '由誰創建';
$lang->task->createdByAB    = '創建者';
$lang->task->createdDate    = '創建日期';
$lang->task->createdDateAB  = '創建';
$lang->task->assignedTo     = '指派給';
$lang->task->assignedDate   = '指派日期';
$lang->task->estStarted     = '預計開始';
$lang->task->realStarted    = '實際開始';
$lang->task->finishedBy     = '由誰完成';
$lang->task->finishedByAB   = '完成者';
$lang->task->finishedDate   = '完成時間';
$lang->task->finishedDateAB = '完成';
$lang->task->canceledBy     = '由誰取消';
$lang->task->canceledDate   = '取消時間';
$lang->task->closedBy       = '由誰關閉';
$lang->task->closedDate     = '關閉時間';
$lang->task->closedReason   = '關閉原因';
$lang->task->lastEditedBy   = '最後修改';
$lang->task->lastEditedDate = '最後修改日期';
$lang->task->lastEdited     = '最後編輯';
$lang->task->hour           = '小時';
$lang->task->leftThisTime   = '剩餘';
$lang->task->date           = '日期';
$lang->task->ditto          = '同上';

$lang->task->confirmFinish  = '"預計剩餘"為0，確認將任務狀態改為"已完成"嗎？';
$lang->task->consumedBefore = '之前消耗';

$lang->task->lblPri = 'P';

$lang->task->statusList['']       = ''; 
$lang->task->statusList['wait']   = '未開始';
$lang->task->statusList['doing']  = '進行中';
$lang->task->statusList['done']   = '已完成';
$lang->task->statusList['cancel'] = '已取消';
$lang->task->statusList['closed'] = '已關閉';

$lang->task->typeList['']        = ''; 
$lang->task->typeList['discuss'] = '討論';
$lang->task->typeList['affair']  = '事務';
$lang->task->typeList['misc']    = '其他';

$lang->task->priList[0]  = '';
$lang->task->priList[1]  = '1';
$lang->task->priList[2]  = '2';
$lang->task->priList[3]  = '3';
$lang->task->priList[4]  = '4';

$lang->task->reasonList['']       = '';
$lang->task->reasonList['done']   = '已完成';
$lang->task->reasonList['cancel'] = '已取消';

$lang->task->createdByMe  = '由我創建';
$lang->task->assignedToMe = '指派給我';
$lang->task->closedByMe   = '由我完成';
$lang->task->untilToday   = '今天到期';
$lang->task->expired      = '已過期';
$lang->task->all          = '所有任務';

$lang->task->basicInfo = '基本信息';
$lang->task->life      = '任務的一生';

$lang->task->kanban  = '看板';
$lang->task->mind    = '腦圖';
$lang->task->list    = '列表';
$lang->task->outline = '大綱';

$lang->task->kanbanGroup['']           = '選擇分組';
$lang->task->kanbanGroup['status']     = '狀態分組';
$lang->task->kanbanGroup['assignedto'] = '指派給分組';

$lang->task->groups['']           = '選擇分組';
$lang->task->groups['status']     = '狀態分組';
$lang->task->groups['assignedto'] = '指派給分組';
$lang->task->groups['createdby']  = '創建者分組';
$lang->task->groups['finishedby'] = '完成者分組';
$lang->task->groups['closedby']   = '關閉者分組';

$lang->task->unkown     = '未指定';
$lang->task->unAssigned = '未指派';

$lang->task->mindMoveTip = '只能將任務移動至二級節點下。';

$lang->task->groupinfo = '總計 <strong class="group-total">%s</strong> 項 - <span class="text-danger">未開始 <strong class="group-wait">%s</strong></span> - <span class="text-warning">進行中 <strong class="group-doing">%s</strong></span> - <span class="text-success">已完成 <strong class="group-done">%s</strong></span> - <span class="text-muted">已關閉 <strong class="group-closed">%s</strong></span>';
