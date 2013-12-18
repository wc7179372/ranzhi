<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
js::set('lang', $lang->js);
?>
<div class='container'>
  <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ) exit($lang->IE6Alert); ?>
  <div id='header'>
    <div class='nav' id="headNav"><?php echo commonModel::printTopBar();?></div>
    <?php if(isset($config->site->logo)):?>
    <?php $logo = json_decode($config->site->logo);?>
    <div id='logoBox' class='f-left'>
      <?php echo html::a($this->config->webRoot, html::image($logo->webPath, "class='logo' title='{$this->config->company->name}'"));?>
    </div>
    <div class='f-left'><p id='slogan'><?php echo $this->config->site->slogan;?></p></div>
    <?php else: ?>
    <div class='f-left' id='name'><h3><?php echo $config->site->name;?></h3></div>
    <div class='f-left' id='slogan'><?php echo $this->config->site->slogan;?></div>
    <?php endif;?>
    <div class='c-both'></div>
  </div>

  <?php $topNavs = $this->loadModel('nav')->getNavs('top');?>
  <nav id='topNav' class='navbar' role="navigation">
    <ul class='nav nav-justified'>
      <?php foreach($topNavs as $nav1):?>
      <li class="cat-item <?php echo $nav1->class?>"> 
        <?php echo html::a($nav1->url, $nav1->title, !empty($nav1->target) ? "target='$nav1->target'" : '');?>
        <?php if(!empty($nav1->children)):?>
        <ul>
          <?php foreach($nav1->children as $nav2):?>
          <li class="cat-item <?php echo $nav2->class?>">
            <?php echo html::a($nav2->url, $nav2->title, !empty($nav2->target) ? "target='$nav2->target'" : '');?>
            <?php if(!empty($nav2->children)):?>
            <ul>
              <?php foreach($nav2->children as $nav3):?>
              <li class='cat-item'><?php echo html::a($nav3->url, $nav3->title, !empty($nav3->target) ? "target='$nav3->target'" : '');?></li>
              <?php endforeach;?>
            </ul>
            <?php endif;?>
          </li>
          <?php endforeach;?>
        </ul>
        <?php endif;?>
      </li>
      <?php endforeach;?>
    </ul>
  </nav>
