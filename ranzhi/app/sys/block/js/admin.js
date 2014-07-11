/**
 * Get all blocks.
 * 
 * @param  string|int $entryID 
 * @access public
 * @return void
 */
function getBlocks(entryID)
{
    var entryBlock = $('#allEntries').parent().parent().next();
    $(entryBlock).hide();
    $('#blockParam').empty();
    if(entryID == '') return false;
    if(entryID.indexOf('hiddenBlock') != -1)
    {
        getRssAndHtmlParams('html', entryID.replace('hiddenBlock', ''));
        return true;
    }
    if(entryID == 'rss' || entryID == 'html')
    {
        getRssAndHtmlParams(entryID);
        return true;
    }

    $.get(createLink('entry', 'blocks', 'entryID=' + entryID + '&index=' + v.index), function(data)
    {
        $(entryBlock).html(data);
        $(entryBlock).show();
        $.ajustModalPosition();
    })
}

/**
 * Get rss and html params.
 * 
 * @param  string $type 
 * @param  int    $blockID 
 * @access public
 * @return void
 */
function getRssAndHtmlParams(type, blockID)
{
    blockID = typeof(blockID) == 'undefined' ? 0 : blockID;
    $.get(createLink('block', 'set', 'index=' + v.index + '&type=' + type + '&blockID=' + blockID), function(data)
    {
        $('#blockParam').html(data);
        $.setAjaxForm('#ajaxForm', function(){parent.location.href=config.webRoot + config.appName;});
        $.ajustModalPosition();
    });
}

/**
 * Get block params.
 * 
 * @param  string $blockID 
 * @param  int    $entryID 
 * @access public
 * @return void
 */
function getBlockParams(blockID, entryID)
{
    $('#blockParam').empty();
    if(blockID == '') return false;

    $.get(createLink('entry', 'setBlock', 'index=' + v.index + '&entryID=' + entryID + '&blockID=' + blockID), function(data)
    {
        $('#blockParam').html(data);
        $.setAjaxForm('#ajaxForm', function(){parent.location.href=config.webRoot + config.appName;});
        $.ajustModalPosition();
    });
}

$(function()
{
    $('#allEntries').change(function(){getBlocks($(this).val())});
    getBlocks($('#allEntries').val());

    $.setAjaxForm('#blockForm', reloadHome);
})
