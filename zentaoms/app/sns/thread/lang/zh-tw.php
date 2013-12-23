<?php
/**
 * The thread module zh-tw file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2013 青島息壤網絡信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->thread->common    = '主題';

$lang->thread->id         = '編號';
$lang->thread->title      = '標題';
$lang->thread->author     = '作者';
$lang->thread->content    = '內容';
$lang->thread->file       = '附件: ';
$lang->thread->postedDate = '發表於';
$lang->thread->replies    = '回帖';
$lang->thread->views      = '閲讀';
$lang->thread->lastReply  = '最後回帖';

$lang->thread->post       = '發貼';
$lang->thread->browse     = '主題列表';
$lang->thread->stick      = '置頂';
$lang->thread->edit       = '編輯主題';
$lang->thread->status     = '狀態';
$lang->thread->hide       = '隱藏';
$lang->thread->show       = '顯示';

$lang->thread->sticks[0] = '不置頂';
$lang->thread->sticks[1] = '版塊置頂';
$lang->thread->sticks[2] = '全局置頂';

$lang->thread->statusList['hidden'] = '已隱藏';
$lang->thread->statusList['normal'] = '正常';

$lang->thread->confirmDeleteThread = "您確定刪除該主題嗎？";
$lang->thread->confirmHideReply    = "您確定隱藏回帖嗎？";
$lang->thread->confirmHideThread   = "您確定隱藏該主題嗎？";
$lang->thread->confirmDeleteReply  = "您確定刪除該回帖嗎？";
$lang->thread->confirmDeleteFile   = "您確定刪除該附件嗎？";

$lang->thread->lblSpeaker     = '<strong>%s</strong><br />訪問次數：%s<br />註冊日期：%s<br />上次訪問：%s<br />';
$lang->thread->lblEdited      = '<i>%s 最後編輯, %s</i> ';
$lang->thread->message        = '%s在論壇#%s回覆了主題：%s，內容為：%s';
$lang->thread->readonly       = '只讀';
$lang->thread->successStick   = '成功置頂';
$lang->thread->successUnstick = '成功取消置頂';
$lang->thread->readonlyMessage = '該帖已被設置為 <strong>只讀</strong>，您暫時無法發表新的回覆。';

/* Adjust the pager. */
if(!isset($lang->pager->settedInForum))
{
    $lang->pager->noRecord = '';
    $lang->pager->digest   = str_replace('記錄', '回貼', $lang->pager->digest);
}
