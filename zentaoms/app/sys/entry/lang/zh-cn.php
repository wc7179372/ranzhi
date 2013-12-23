<?php
/**
 * The zh-cn file of entry module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->entry->common    = '应用';
$lang->entry->admin     = '应用列表';
$lang->entry->create    = '添加应用';
$lang->entry->edit      = '编辑应用';
$lang->entry->delete    = '删除应用';
$lang->entry->code      = '代号';
$lang->entry->name      = '名称';
$lang->entry->key       = '密钥';
$lang->entry->ip        = 'IP列表';
$lang->entry->logo      = 'Logo';
$lang->entry->createKey = '重新生成密钥';
$lang->entry->login     = '登录地址';
$lang->entry->logout    = '退出地址';
$lang->entry->nothing   = '暂时没有应用';
$lang->entry->openMode  = '打开方式';

$lang->entry->confirmDelete = '您确定删除该应用吗？';

$lang->entry->note = new stdClass();
$lang->entry->note->name    = '授权应用名称';
$lang->entry->note->code    = '授权应用代号';
$lang->entry->note->login   = '登录应用的表单提交地址';
$lang->entry->note->logout  = '退出应用的地址';
$lang->entry->note->visible = '显示在首页左侧栏';
$lang->entry->note->ip      = "允许该应用使用这些ip访问，多个ip使用逗号隔开。支持IP段，如192.168.1.*";

$lang->entry->error = new stdClass();
$lang->entry->error->name  = '名称不能为空';
$lang->entry->error->code  = '代号不能为空';
$lang->entry->error->key   = '密钥不能为空';
$lang->entry->error->ip    = 'IP列表不能为空';

$lang->entry->modeList['']         = '';
$lang->entry->modeList['blank']    = '新开标签';
$lang->entry->modeList['ajaxHtml'] = 'ajax获取Html';
$lang->entry->modeList['ajaxJson'] = 'ajax获取Json';
$lang->entry->modeList['iframe']   = 'iframe框架';

$lang->entry->instruction = <<<EOT
EOT;
