<?php 
/**
 * The create view of shema module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     shema 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php 
if(!empty($records))
{ 
    include 'create.form.html.php';
    exit;
}
?>
<?php if(empty($records))  include 'create.upload.html.php';?>
