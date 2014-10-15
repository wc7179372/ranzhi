<?php
/**
 * The zh-tw file of crm common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->app = new stdclass();
$lang->app->name = 'CRM';

$lang->menu->crm = new stdclass();
$lang->menu->crm->dashboard = '我的地盤|dashboard|index|';
$lang->menu->crm->order     = '訂單|order|index|';
$lang->menu->crm->contract  = '合同|contract|index|';
$lang->menu->crm->customer  = '客戶|customer|index|';
$lang->menu->crm->contact   = '聯繫人|contact|index|';
$lang->menu->crm->product   = '產品|product|index|';
$lang->menu->crm->setting   = '設置|setting|lang|module=product&field=statusList';

/* Menu of customer module. */
$lang->customer = new stdclass();
$lang->customer->menu = new stdclass();
$lang->customer->menu->browse    = array('link' => '全部客戶|customer|browse|mode=all', 'alias' => 'create,edit,view,record');
$lang->customer->menu->past      = array('link' => '亟需聯繫|customer|browse|mode=past', 'alias' => 'create,edit,view,record');
$lang->customer->menu->today     = array('link' => '今天聯繫|customer|browse|mode=today', 'alias' => 'create,edit,view,record');
$lang->customer->menu->tomorrow  = array('link' => '明天聯繫|customer|browse|mode=tomorrow', 'alias' => 'create,edit,view,record');
$lang->customer->menu->thisweek  = array('link' => '一周內聯繫|customer|browse|mode=thisweek', 'alias' => 'create,edit,view,record');
$lang->customer->menu->thismonth = array('link' => '一月內聯繫|customer|browse|mode=thismonth', 'alias' => 'create,edit,view,record');
$lang->customer->menu->public    = array('link' => '公共客戶|customer|browse|mode=public', 'alias' => 'create,edit,view,record');

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse = array('link' => '<i class="icon-th"></i> 產品列表|product|browse|', 'alias' => 'create,edit');

/* Menu of order module. */
$lang->order = new stdclass();
$lang->order->menu = new stdclass();
$lang->order->menu->browse    = array('link' => '全部訂單|order|browse|mode=all', 'alias' => 'create,edit,view,record');
$lang->order->menu->past      = array('link' => '亟需聯繫|order|browse|mode=past', 'alias' => 'create,edit,view,record');
$lang->order->menu->today     = array('link' => '今天聯繫|order|browse|mode=today', 'alias' => 'create,edit,view,record');
$lang->order->menu->tomorrow  = array('link' => '明天聯繫|order|browse|mode=tomorrow', 'alias' => 'create,edit,view,record');
$lang->order->menu->thisweek  = array('link' => '一周內聯繫|order|browse|mode=thisweek', 'alias' => 'create,edit,view,record');
$lang->order->menu->thismonth = array('link' => '一月內聯繫|order|browse|mode=thismonth', 'alias' => 'create,edit,view,record');
$lang->order->menu->public    = array('link' => '公共客戶|order|browse|mode=public', 'alias' => 'create,edit,view,record');

/* Menu of contact module. */
$lang->contact = new stdclass();
$lang->contact->menu = new stdclass();
$lang->contact->menu->browse = array('link' => '<i class="icon-th-list"></i> 聯繫人列表|contact|browse|mode=all', 'alias' => 'create,edit,view,history');
$lang->contact->menu->past      = array('link' => '亟需聯繫|contact|browse|mode=past', 'alias' => 'create,edit,view,record');
$lang->contact->menu->today     = array('link' => '今天聯繫|contact|browse|mode=today', 'alias' => 'create,edit,view,record');
$lang->contact->menu->tomorrow  = array('link' => '明天聯繫|contact|browse|mode=tomorrow', 'alias' => 'create,edit,view,record');
$lang->contact->menu->thisweek  = array('link' => '一周內聯繫|contact|browse|mode=thisweek', 'alias' => 'create,edit,view,record');
$lang->contact->menu->thismonth = array('link' => '一月內聯繫|contact|browse|mode=thismonth', 'alias' => 'create,edit,view,record');

/* Menu of contract module. */
$lang->contract = new stdclass();
$lang->contract->menu = new stdclass();
$lang->contract->menu->browse       = array('link' => '合同列表|contract|browse|mode=all', 'alias' => 'create,edit,view');
$lang->contract->menu->unreceived   = array('link' => '未回款|contract|browse|mode=unreceived',   'alias' => 'create,edit,view,history');
$lang->contract->menu->undeliveried = array('link' => '未交付|contract|browse|mode=undeliveried', 'alias' => 'create,edit,view,history');
$lang->contract->menu->finished     = array('link' => '已完成|contract|browse|mode=finished',   'alias' => 'create,edit,view,history');
$lang->contract->menu->canceled     = array('link' => '已取消|contract|browse|mode=canceled',   'alias' => 'create,edit,view,history');
$lang->contract->menu->expired      = array('link' => '已過期|contract|browse|mode=expired',   'alias' => 'create,edit,view,history');

/* Menu of setting module. */
$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->product       = '產品狀態|setting|lang|module=product&field=statusList';
$lang->setting->menu->customerType  = '客戶類型|setting|lang|module=customer&field=typeList';
$lang->setting->menu->customerSize  = '客戶規模|setting|lang|module=customer&field=sizeNameList';
$lang->setting->menu->customerLevel = '客戶等級|setting|lang|module=customer&field=levelNameList';
$lang->setting->menu->area          = '區域設置|tree|browse|type=area|';
$lang->setting->menu->industry      = '行業設置|tree|browse|type=industry|';
$lang->setting->menu->currency      = '貨幣設置|setting|lang|module=order&field=currencyList';

$lang->dashboard = new stdclass();
$lang->resume    = new stdclass();
$lang->address   = new stdclass();
