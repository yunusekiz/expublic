jQuery.noConflict()(function($){
$(document).ready(function ()
{ // после загрузки DOM
    $("#ajax-contact-form").submit(function ()
    {
        var str = $(this).serialize(); 
        $.ajax(
        {
            type: "POST",
            url: "eposta",
            data: str,
            success: function (msg)
            {
                $("#note").ajaxComplete(function (event, request, settings)
                {
                    if (msg == 'OK') 
                    {
                        result = '<div class="notification_ok">Mesajınız bize ulaştı, teşekkürler!</div>';
                        $("#fields").hide();
                    }
                    else
                    {
                        result = msg;
                    }
                    $(this).html(result);
                });
            }
        });
        return false;
    });
});
});