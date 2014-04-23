$(document).ready(function()
{
    $(document).on('click', '.plus', function()
    {
        $(this).parents('tr').after("<tr id='orderTR'><th></th><td id='orderTD'>" + $('#orderTD').html() + "</td></tr>");
    });
  
    $(document).on('click', '.minus', function()
    {
        if($(this).parents('table').find('.order-real').size() == 1)
        {
            $(this).parents('td').find('select').val('').change();
            return false;
        }
        $(this).parents('tr').remove();
        $('.order-real').change();
    });
})
