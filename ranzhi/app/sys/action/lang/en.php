<?php
/**
 * The action module English file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     action
 * @version     $Id: zh-cn.php 4955 2013-07-02 01:47:21Z chencongzhi520@gmail.com $
 * @link        http://www.ranzhi.org
 */
$lang->action->common   = 'Logs';
$lang->action->product  = 'Product';
$lang->action->actor    = 'Actor';
$lang->action->action   = 'Action';
$lang->action->actionID = 'Action ID';
$lang->action->date     = 'Date';

$lang->action->editComment = 'Edit Comment';

$lang->action->textDiff = 'Text Mode';
$lang->action->original = 'Original content';

/* The desc of actions. */
$lang->action->desc = new stdclass();
$lang->action->desc->common      = '$date, <strong>$action</strong> by <strong>$actor</strong>.';
$lang->action->desc->extra       = '$date, <strong>$action</strong> as <strong>$extra</strong> by <strong>$actor</strong>.';
$lang->action->desc->opened      = '$date, opened by <strong>$actor</strong>.';
$lang->action->desc->created     = '$date, created by <strong>$actor</strong>.';
$lang->action->desc->edited      = '$date, edited by <strong>$actor</strong>.';
$lang->action->desc->assigned    = '$date, <strong>$actor</strong> assigned task to <strong>$extra</strong>.' . "\n";
$lang->action->desc->closed      = '$date, closed by <strong>$actor</strong>.';
$lang->action->desc->deleted     = '$date, deleted by <strong>$actor</strong>.';
$lang->action->desc->deletedfile = '$date, deleted file by <strong>$actor</strong>, the file is <strong><i>$extra</i></strong>.';
$lang->action->desc->editfile    = '$date, edit file by <strong>$actor</strong>, the file is <strong><i>$extra</i></strong>.';
$lang->action->desc->erased      = '$date, erased by <strong>$actor</strong>.';
$lang->action->desc->commented   = '$date, commented by <strong>$actor</strong>.';
$lang->action->desc->activated   = '$date, activated by <strong>$actor</strong>.';
$lang->action->desc->moved       = '$date, moved by <strong>$actor</strong>, previouse is "$extra".';
$lang->action->desc->started     = '$date, started by <strong>$actor</strong>.';
$lang->action->desc->delayed     = '$date, delayed by <strong>$actor</strong>.';
$lang->action->desc->suspended   = '$date, suspended by <strong>$actor</strong>.';
$lang->action->desc->canceled    = '$date, canceled by <strong>$actor</strong>.';
$lang->action->desc->finished    = '$date, finished by <strong>$actor</strong>.';
$lang->action->desc->replied     = '$date, replied by <strong>$actor</strong>.' . "\n";
$lang->action->desc->doubted     = '$date, doubted by <strong>$actor</strong>.' . "\n";
$lang->action->desc->transfered  = '$date, transfered by <strong>$actor</strong>.' . "\n";
$lang->action->desc->diff1       = 'changed <strong><i>%s</i></strong>, old is "%s", new is "%s".<br />';
$lang->action->desc->diff2       = 'changed <strong><i>%s</i></strong>, the diff is:' . "\n" . "<blockquote>%s</blockquote>" . "\n<div class='hidden'>%s</div>";
$lang->action->desc->diff3       = "changed file's name %s to %s.";

/* The action labels. */
$lang->action->label = new stdclass();
$lang->action->label->created     = 'created';
$lang->action->label->edited      = 'edited';
$lang->action->label->assigned    = 'assigned';
$lang->action->label->closed      = 'closed';
$lang->action->label->deleted     = 'deleted';
$lang->action->label->deletedfile = 'deleted file';
$lang->action->label->editfile    = 'edit file name';
$lang->action->label->commented   = 'commented';
$lang->action->label->activated   = 'activated';
$lang->action->label->resolved    = 'resolved';
$lang->action->label->reviewed    = 'reviewed';
$lang->action->label->moved       = 'moved';
$lang->action->label->marked      = 'edited';
$lang->action->label->started     = 'started';
$lang->action->label->canceled    = 'canceled';
$lang->action->label->finished    = 'finished';
$lang->action->label->login       = 'login';
$lang->action->label->logout      = "logout";

/* Link of every action. */
$lang->action->label->product = 'product|product|view|productID=%s';
$lang->action->label->order   = 'order|order|view|orderID=%s';
$lang->action->label->task    = 'task|task|view|taskID=%s';
$lang->action->label->user    = 'user|user|view|account=%s';
$lang->action->label->space   = ' ';

/* Object type. */
$lang->action->search->objectTypeList['']            = '';    
$lang->action->search->objectTypeList['product']     = 'product';    
$lang->action->search->objectTypeList['task']        = 'task'; 
$lang->action->search->objectTypeList['user']        = 'user'; 
$lang->action->search->objectTypeList['order']       = 'order'; 
$lang->action->search->objectTypeList['orderAction'] = 'order action'; 

/* Display action for search. */
$lang->action->search->label['']            = '';
$lang->action->search->label['created']     = $lang->action->label->created;
$lang->action->search->label['edited']      = $lang->action->label->edited;
$lang->action->search->label['assigned']    = $lang->action->label->assigned;
$lang->action->search->label['closed']      = $lang->action->label->closed;
$lang->action->search->label['deleted']     = $lang->action->label->deleted;
$lang->action->search->label['deletedfile'] = $lang->action->label->deletedfile;
$lang->action->search->label['editfile']    = $lang->action->label->editfile;
$lang->action->search->label['commented']   = $lang->action->label->commented;
$lang->action->search->label['activated']   = $lang->action->label->activated;
$lang->action->search->label['resolved']    = $lang->action->label->resolved;
$lang->action->search->label['reviewed']    = $lang->action->label->reviewed;
$lang->action->search->label['moved']       = $lang->action->label->moved;
$lang->action->search->label['started']     = $lang->action->label->started;
$lang->action->search->label['canceled']    = $lang->action->label->canceled;
$lang->action->search->label['finished']    = $lang->action->label->finished;
$lang->action->search->label['login']       = $lang->action->label->login;
$lang->action->search->label['logout']      = $lang->action->label->logout;