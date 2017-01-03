$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

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

    $('.input-file').ace_file_input({
        no_file:'Sin imagen...',
        btn_choose:'Seleccionar',
        btn_change:'Cambiar',
        droppable:false,
        onchange:null,
        thumbnail:false, //| true | large
        whitelist:'gif|png|jpg|jpeg|bmp',
        allowExt: ["jpeg","jpg","png","gif","bmp"]
        //blacklist:'exe|php'
        //onchange:''
        //
    });
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