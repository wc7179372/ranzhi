<?php
/**
 * The children view of tree module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<form method='post' class='form-horizontal' id='childForm' action="<?php echo inlink('children', "type=$type&category=$parent");?>">
  <div class='panel'>
    <div class='panel-heading'>
    <strong><?php echo $parent ? $lang->category->children . ' <i class="icon-double-angle-right"></i> ' : $lang->category->common; ?></strong>
    <?php
    foreach($origins as $origin)
    {
        echo html::a(inlink('browse', "type=$type&&category=$origin->id"), $origin->name . " <i class='icon-angle-right text-muted'></i> ");
    }
    ?>
    </div>

    <div class='panel-body'>
      <?php
      $maxOrder = 0;
      foreach($children as $child)
      {
          if($child->order > $maxOrder) $maxOrder = $child->order;
          echo "<div class='form-group'>";
          echo "<div class='col-xs-6 col-md-4 col-md-offset-2'>" . html::input("children[$child->id]", $child->name, "class='form-control'") . "</div>";
          if($type != 'dept') echo "<div class='col-xs-6 col-md-4'>" . html::input("alias[$child->id]", $child->alias, "class='form-control' placeholder='{$this->lang->category->alias}'") . '</div>';
          echo "</div>";
          echo html::hidden("mode[$child->id]", 'update');
      }

      for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++)
      {
          echo "<div class='form-group'>";
          echo "<div class='col-xs-6 col-md-4 col-md-offset-2'>" . html::input("children[]", '', "class='form-control' placeholder='{$this->lang->category->name}'") . "</div>";
          if($type != 'dept') echo "<div class='col-xs-6 col-md-4'>" . html::input("alias[]", '', "class='form-control' placeholder='{$this->lang->category->alias}'") . '</div>';
          echo "</div>";
          echo html::hidden('mode[]', 'new');
      }

      $button = ($type == 'dept') ? html::submitButton() . html::backButton() : html::submitButton();
      echo "<div class='form-group'><div class='col-xs-8 col-md-offset-2'>" . $button . "</div></div>";
      echo html::hidden('parent',   $parent);
      echo html::hidden('maxOrder', $maxOrder);
      ?>
    </div>
  </div>
</form>
<?php if(isset($pageJS)) js::execute($pageJS);?>
