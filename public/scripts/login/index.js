
function btnLogin_onClick() {
    var userData = {
        username: $("#user").val(),
        password: $("#pass").val(),
        rememberMe: $("#recuerdame").prop("checked")
    };

    $.ajax({
        type: 'POST',
        url: 'http://localhost:8000/auth/login',
        data: userData,
        dataType: "json",
        async: true,
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        error: function (e) {
            console.log(e);
        },
        success: function (result) {
            if (result.valid) {
                window.location.replace("http://localhost:8000/home");
                console.log("Login OK!!!");
            }
            else {
                $("#alerta #text").html(result.message);
                $("#alerta").css("display", "");
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
