<?php
/**
 * The order module en file of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->order->common = 'Order';
$lang->order->effort = 'Effort';

$lang->order->id            = 'ID';
$lang->order->name          = 'Name';
$lang->order->product       = 'Product';
$lang->order->customer      = 'Customer';
$lang->order->contact       = 'Contact';
$lang->order->team          = 'Team';
$lang->order->plan          = 'Planned Amount';
$lang->order->real          = 'Real Amount';
$lang->order->status        = 'Status';
$lang->order->createdBy     = 'Created By';
$lang->order->createdDate   = 'Created Date';
$lang->order->assignedTo    = 'Assigned to';
$lang->order->assignedBy    = 'Assigned By';
$lang->order->assignedDate  = 'Assigned Date';
$lang->order->signedBy      = 'Signed By';
$lang->order->signedDate    = 'Signed Date';
$lang->order->payedDate     = 'Payed Date';
$lang->order->closedBy      = 'Closed By';
$lang->order->closedDate    = 'Closed Date';
$lang->order->closedReason  = 'Closed Reason';
$lang->order->closedNote    = 'Closed Note';
$lang->order->activatedBy   = 'Activated By';
$lang->order->activatedDate = 'Activated Date';
$lang->order->contactedBy   = 'Contacted By';
$lang->order->contactedDate = 'Contacted Date';

$lang->order->list          = 'List';
$lang->order->browse        = 'Browse';
$lang->order->create        = 'Create';
$lang->order->edit          = 'Update';
$lang->order->view          = 'Info';
$lang->order->close         = 'Close';
$lang->order->manageMembers = 'Manage Members';
$lang->order->sign          = 'Sign';
$lang->order->createTasks   = 'Create Tasks';

$lang->order->statusList['normal']   = 'Normal';
$lang->order->statusList['assigned'] = 'Assigned';
$lang->order->statusList['signed']   = 'Signed';
$lang->order->statusList['payed']    = 'Payed';
$lang->order->statusList['closed']   = 'Closed';

$lang->order->statusAccents['normal']   = '';
$lang->order->statusAccents['assigned'] = 'alert-warning';
$lang->order->statusAccents['signed']   = 'alert-info';
$lang->order->statusAccents['payed']    = 'alert-success';
$lang->order->statusAccents['closed']   = '';

$lang->order->closedReasonList['payed']     = 'Payed';
$lang->order->closedReasonList['failed']    = 'Failed';
$lang->order->closedReasonList['postponed'] = 'Postponed';

$lang->order->history   = 'History';
$lang->order->created   = 'Created by <strong>%s</strong>.';
$lang->order->assigned  = "<strong>%s</strong> assigned order to %s";
$lang->order->signed    = "Signed by <strong>%s</strong>";
$lang->order->activated = "Activated by <strong>%s</strong>";

$lang->team = new stdclass();
$lang->team->account = 'Account';
$lang->team->role    = 'Role';
$lang->team->join    = 'Join';