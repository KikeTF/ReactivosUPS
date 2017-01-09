$('#planteamiento').keyup(function(){
    var validator = $( "#formulario" ).validate();
    validator.resetForm();

    if($(this).val() != "" && $(this).val() === $(this).val().toUpperCase()){
        if (CapsLock.isOn()){
            validator.showErrors({"planteamiento": "Block Mayus activado!"});
        }else{
            validator.showErrors({"planteamiento": "Utilizar min&uacute;sculas y may&uacute;sculas!"});
        }
    }
});

function isUpperCase(){
    result = false;
    var validator = $( "#formulario" ).validate();

    value = $('#planteamiento').val();
    if(value != "" && value === value.toUpperCase()){
        result = true;
        validator.form();
        validator.showErrors({"planteamiento": "Utilizar min&uacute;sculas y may&uacute;sculas!"});
    }

    return result;
}

jQuery(function($) {
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