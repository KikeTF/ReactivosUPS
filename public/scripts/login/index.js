
function btnLogin_onClick() {
    var userData = {
        username: $("#user").val(),
        password: $("#pass").val(),
        rememberMe: $("#recuerdame").prop("checked")
    };

    $.ajax({
        url: 'Login/ValidateLogin',
        type: 'post',
        data: userData,
        async: true,
        cache: false,
        error: function (e) {
            console.log(e);
        },
        success: function (result) {
            console.log(result);
            if (result.valid) {
                //$("#btn_login").html('Validado');
                //$("#btn_login").jqxButton({ disabled: true });
                //showNotification(result.Message, 'success');
                window.location.href = "/";
            }
            else {
                $("#alerta #text").html(result.message);
                $("#alerta").css("display", "");
                //showNotification(result.Message, 'error');
            }
        }
    });
}

jQuery(function ($) {
    $(document).on('click', '.toolbar a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });

    $("#user").on("focus", function () {
        $("#alerta").css("display", "none");
    });

    $("#user").on("blur", function() {
        $("#alerta").css("display", "none");
    });

    $("#pass").on("focus", function () {
        $("#alerta").css("display", "none");
    });

    $("#pass").on("blur", function () {
        $("#alerta").css("display", "none");
    });

    $('#btnLogin').click(btnLogin_onClick);
});
