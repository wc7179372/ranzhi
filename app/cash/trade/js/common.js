$(document).ready(function()
{
    $('[name*=objectType]').change(function()
    {
        if($(this).prop('checked'))$('[name*=objectType]').not(this).prop('checked', false).change();
        $('#' + $(this).val()).parents('tr').toggle($(this).prop('checked'))
    })
    $('[name*=objectType]').change();

    $('[name*=createTrader]').change(function()
    {
        if($(this).prop('checked')) 
        {
            $(this).parents('.input-group').find('select').hide();
            $('#trader_chosen').hide();
            $(this).parents('.input-group').find('input[type=text][id=traderName]').show().focus();
        }
        else
        {
            $('#trader_chosen').show();
            $(this).parents('.input-group').find('input[type=text][id=traderName]').hide();
        }
    })
})
