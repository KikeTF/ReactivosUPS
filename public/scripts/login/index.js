jQuery(function ($) {
    $(document).on('click', '.toolbar a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });

    $("#username").on("focus", function () {
        $("#alerta").css("display", "none");
    });

    $("#username").on("blur", function() {
        $("#alerta").css("display", "none");
    });

    $("#password").on("focus", function () {
        $("#alerta").css("display", "none");
    });

    $("#password").on("blur", function () {
        $("#alerta").css("display", "none");
    });

});
