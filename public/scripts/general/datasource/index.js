jQuery(function($) {
    $('.input-file').ace_file_input({
        no_file:'Seleccionar archivo...',
        btn_choose:'Seleccionar',
        btn_change:'Cambiar',
        droppable:false,
        onchange:null,
        thumbnail:false, //| true | large
        whitelist:'csv',
        allowExt: ["csv"]
        //blacklist:'exe|php'
        //onchange:''
        //
    });
});