$(document).ready(function()
{
    if(!v.dateOptions)
    {
        bootbox.alert(v.createBalance, function(){ location.href = createLink('balance', 'create')});
    }

    $('.btn-save-result').click(function()
    {
        var btn = $(this);
        $.getJSON(btn.attr('href'), function(response)
        {
            messager.success(response.message);
            $('#submit').click(); 
        });    
        return false;
    })
});
