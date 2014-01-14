<?php
/**
 * The zh-cn file of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->app = new stdclass();
$lang->app->name = 'CRM';

$lang->menu->crm = new stdclass();
$lang->menu->crm->dashboard = '我的地盘|dashboard|index|';
$lang->menu->crm->order     = '订单|order|index|';
$lang->menu->crm->task      = '任务|task|index|';
$lang->menu->crm->customer  = '客户|customer|index|';
$lang->menu->crm->contract  = '合同|contract|index|';
$lang->menu->crm->product   = '产品|product|index|';
$lang->menu->crm->contact   = '联系人|contact|index|';
$lang->menu->crm->feedback  = '售后|feedback|index|';

/* Menu of customer module. */
$lang->customer = new stdclass();
$lang->customer->menu = new stdclass();
$lang->customer->menu->browse = array('link' => '客户列表|customer|admin|', 'alias' => 'edit');
$lang->customer->menu->create = '添加客户|customer|create|type=customer';