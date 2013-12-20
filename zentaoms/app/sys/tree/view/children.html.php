<form method='post' id='childForm' action="<?php echo $this->inlink('children', "type=$type&book=$book");?>">
  <table class='table table-form'>
    <caption><?php echo $parent ? $lang->category->children : $lang->category->common;?></caption>
    <tr>
      <th class='w-p10'>
        <nobr>
        <?php
        $chevron = '<i class="icon-chevron-right"></i>';
        foreach($origins as $origin)
        {
            echo html::a($this->inlink('browse', "type=$type&book=$book&category=$origin->id"), $origin->name . $chevron);
        }
        ?>
        </nobr>
      </th>
      <td> 
        <?php
        $maxOrder = 0;
        foreach($children as $child)
        {
            if($child->order > $maxOrder) $maxOrder = $child->order;
            echo '<p>' . html::input("children[$child->id]", $child->name);
            echo html::input("alias[$child->id]", $child->alias, "placeholder='{$this->lang->category->alias}'") . '</p>';
            echo html::hidden("mode[$child->id]", 'update');
        }

        for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++)
        {
            echo '<p>' . html::input("children[]", '', "placeholder='{$this->lang->category->name}'");
            echo html::input("alias[]", '', "placeholder='{$this->lang->category->alias}'") . '</p>';
            echo html::hidden('mode[]', 'new');
        }

        echo html::submitButton();
        echo html::hidden('parent',   $parent);
        echo html::hidden('maxOrder', $maxOrder);
        ?>      
      </td>
    </tr>
  </table>
</form>
<?php if(isset($pageJS)) js::execute($pageJS);?>
