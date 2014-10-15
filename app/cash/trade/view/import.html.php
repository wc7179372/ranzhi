<?php 
/**
 * The import view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     trade 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<div class='panel'>
    <form method='post' id='ajaxForm' enctype='multipart/form-data' action='<?php echo inlink('import')?>'>
    <table class='table table-form'>
      <tr>
        <th class='w-80px'><?php echo $lang->trade->depositor?></th>
        <td class='w-p40'><?php echo html::select('depositor', $depositors, '', "class='form-control'")?></td>
        <th class='w-60px'><?php echo $lang->trade->schema?></th>
        <td><?php echo html::select('schema', $schemas, '', "class='form-control'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->trade->importFile?></th>
        <td><?php echo html::file('files', "class='form-control'")?></td>
        <th><?php echo $lang->trade->encode?></th>
        <td><?php echo html::select('encode', $lang->trade->encodeList, '', "class='form-control'")?></td>
      </tr>
      <tr>
        <th></th>
        <td colspan='3'><?php echo html::submitButton() . $lang->trade->fileNode;?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
