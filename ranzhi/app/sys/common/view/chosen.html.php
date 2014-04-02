<?php
/**
 * The chosen view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
css::import($jsRoot . 'jquery/chosen/min.css');
js::import($jsRoot . 'jquery/chosen/min.js');
?>

<script language='javascript'> 
$(document).ready(function()
{
    $(".chosen").chosen({no_results_text: '<?php echo $lang->noResultsMatch;?>', placeholder_text:' ', disable_search_threshold: 10, width: '100%'});
});
</script>
