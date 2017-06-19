$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

$(".chosen-select").on('change', function(){
    $(this).closest('form').validate().element($(this));
});

$(".select2").on('change', function(){
    $(this).closest('form').validate().element($(this));
});

jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es requerido.",
    remote: "Please fix this field.",
    email: "Por favor ingrese un correo electronico valido.",
    url: "Por favor ingrese una URL valido.",
    date: "Por favor ingrese una fecha valida.",
    //dateISO: "Por favor ingrese una fecha (ISO) valida.",
    number: "Por favor ingrese un numero valido.",
    digits: "Por favor ingrese solo digitos.",
    //creditcard: "Please enter a valid credit card number.",
    //equalTo: "Please enter the same value again.",
    //accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Por favor ingrese no mas de {0} caracteres."),
    minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres."),
    //rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    //range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Por favor ingrese un numero menor o igual a {0}."),
    min: jQuery.validator.format("Por favor ingrese un numero mayor o igual a {0}.")
});

var validator = $('#formulario').validate({
    errorElement: 'div',
    errorClass: 'help-block',
    focusInvalid: false,
    ignore: "",
    /*
     rules: {
     email: {
     required: true,
     email:true
     },
     password: {
     required: true,
     minlength: 5
     },
     password2: {
     required: true,
     minlength: 5,
     equalTo: "#password"
     },
     name: {
     required: true
     }
     },

     message: {
     email: {
     required: "Please provide a valid email.",
     email: "Please provide a valid email."
     },
     password: {
     required: "Please specify a password.",
     minlength: "Please specify a secure password."
     }
     },
     */
    highlight: function (e) {
        $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
    },

    success: function (e) {
        $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
    },

    errorPlacement: function (error, element) {
        if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
            var controls = element.closest('div[class*="col-"]');
            if(controls.find(':checkbox,:radio').length > 1)
                controls.append(error);
            else
                error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
        }
        else if(element.is('.select2')) {
            error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
        }
        else if(element.is('.chosen-select')) {
            error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
        }
        else {
            error.insertAfter(element.parent());
        }

    },
    submitHandler: function (form) {
        $('#finishMessage').empty();
        $('#finishMessage').append('<h4>Presione <strong class="green">"Finalizar"</strong> para solicitar aprobaci&oacute;n!</h4>');
        $("#formulario").submit();
    },
    invalidHandler: function (event, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {
            var message = errors == 1
                ? 'Por favor ingrese el campo faltante.'
                : 'Por favor ingrese los ' + errors + ' campos faltantes.';
            $('#finishMessage').empty();
            $('#finishMessage').append('<h4 class="red">' + message + '</h4>');
            bootbox.alert({
                message: message,
                buttons: {
                    'ok': {
                        label: 'Cerrar',
                        className: 'btn-danger'
                    }
                }
            });
        }
    }
});

function clearErrors(){
    $('#formulario .form-group').removeClass('has-error');
    $("[id$='-error']").remove();
}

jQuery(function($) {
    if(!ace.vars['touch']) {
        $('.chosen-select').chosen({allow_single_deselect:true});

        //resize the chosen on window resize
        $(window)
            .off('resize.chosen')
            .on('resize.chosen', function() {
                $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                })
            }).trigger('resize.chosen');

        //resize chosen on sidebar collapse/expand
        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
            if(event_name != 'sidebar_collapsed') return;
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        });
    }
});

function spinnerLoadingStart() {
    var opts = {
        lines: 13 // The number of lines to draw
        , length: 30 // The length of each line
        , width: 10 // The line thickness
        , radius: 25 // The radius of the inner circle
        , scale: 1 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#000' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'fixed' // Element positioning
    }
    var target = document.getElementById('spinner-preview')
    var spinner = new Spinner(opts).spin(target);
    $(target).data('spinner', spinner);
}

function spinnerLoadingStop(){
    $('#spinner-preview').data('spinner').stop();
}