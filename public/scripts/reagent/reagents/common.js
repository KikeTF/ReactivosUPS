$('#planteamiento').keyup(function(){
    var validator = $( "#formulario" ).validate();
    validator.resetForm();
    $(this).parent().parent().parent().removeClass( "has-error");

    if($(this).val().length > 1 && $(this).val() === $(this).val().toUpperCase()){
        if (CapsLock.isOn()){
            validator.showErrors({"planteamiento": "Block Mayus activado!"});
        }else{
            validator.showErrors({"planteamiento": "Utilizar min&uacute;sculas y may&uacute;sculas!"});
        }
    }
});

function inputFileLoad(){
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
}

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

function formatOptionAction(ind, type, action) {
    //i: Indice de la opcion
    //type: A=Respuesta, C=Concepto Pregunta, P=Propiedad Pregunta
    //action: 0=Deshabilitar, 1=Habilitar
    enab = (action == 1);
    switch(type) {
        case 'A':
            $("#activa_op_resp_"+ind).attr("hidden", enab);
            $("#desactiva_op_resp_"+ind).attr("hidden", !enab);
            $("#id_opcion_correcta_"+ind).attr("disabled", !enab);
            $("#desc_op_resp_"+ind).attr("disabled", !enab);
            $("#arg_op_resp_"+ind).attr("disabled", !enab);
            $("#id_resp_"+ind).attr("disabled", !enab);
            break;
        case 'C':
            $("#conc_activa_op_preg_"+ind).attr("hidden", enab);
            $("#conc_desactiva_op_preg_"+ind).attr("hidden", !enab);
            $("#conc_op_preg_"+ind).attr("disabled", !enab);
            $("#conc_id_preg_"+ind).attr("disabled", !enab);
            break;
        case 'P':
            $("#prop_activa_op_preg_"+ind).attr("hidden", enab);
            $("#prop_desactiva_op_preg_"+ind).attr("hidden", !enab);
            $("#prop_op_preg_"+ind).attr("disabled", !enab);
            $("#prop_id_preg_"+ind).attr("disabled", !enab);
            break;
        default:
            console.log("El tipo de opcion especificado es incorrecto.")

    }
}