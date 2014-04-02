$(document).ready(function()
{
    /* Set forbid link options. */
    $('td.operate a.forbider').click(function()
    {
        $.getJSON($(this).attr('href'),function(data)
        {
            if(data.result == 'success') return location.href = data.locate;
            bootbox.alert(data.message + '');
        });
        return false;
    });

    $('.form-search').submit(function()
    {
        var inputValue = $(".search-query").val();
        if(inputValue == '')
        {
            alert('请输入用户名');
            return false;
        }
    });
    
    if(v.deptID) $('#category' + v.deptID).addClass('red');
});
