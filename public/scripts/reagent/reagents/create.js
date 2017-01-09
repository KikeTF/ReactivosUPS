$('#id_formato').on('change', function() {
    var prefix = "f"+this.value+"_";
    for(i = 1; i <= $("#format_count").val(); i++){
        var id = document.getElementById("secuencial_"+i).value;
        document.getElementById("reagent_format_"+id).style.display = 'none';
        $("#reagent_format_"+id).find('input, textarea, button, select').attr('disabled','disabled');
    }
    document.getElementById("reagent_format_"+this.value).style.display = 'block';
    $("#reagent_format_"+this.value).find('input, textarea, button, select').prop('disabled', false);

    for(i = 1; i <= $("#"+prefix+"format_resp_max").val(); i++){
        if(i > $("#"+prefix+"format_resp_min").val()){
            $("#"+prefix+"desc_op_resp_"+i).attr('disabled','disabled');
            $("#"+prefix+"arg_op_resp_"+i).attr('disabled','disabled');
            $("#"+prefix+"id_opcion_correcta_"+i).attr('disabled', 'disabled');
        }
    }

    for(i = 1; i <= $("#"+prefix+"format_preg_max").val(); i++){
        if(i > $("#"+prefix+"format_preg_min").val()){
            $("#"+prefix+"conc_op_preg_"+i).attr('disabled','disabled');
            $("#"+prefix+"prop_op_preg_"+i).attr('disabled','disabled');
        }
    }
});

function activa_op_resp(ind) {
    var prefix = "f"+$('#id_formato').val()+"_";
    $("#"+prefix+"activa_op_resp_"+ind).attr("hidden", true);
    $("#"+prefix+"desactiva_op_resp_"+ind).attr("hidden", false);
    $("#"+prefix+"id_opcion_correcta_"+ind).attr("disabled", false);
    $("#"+prefix+"desc_op_resp_"+ind).attr("disabled", false);
    $("#"+prefix+"arg_op_resp_"+ind).attr("disabled", false);
}

function desactiva_op_resp(ind) {
    var prefix = "f"+$('#id_formato').val()+"_";
    $("#"+prefix+"desactiva_op_resp_"+ind).attr("hidden", true);
    $("#"+prefix+"activa_op_resp_"+ind).attr("hidden", false);
    $("#"+prefix+"desc_op_resp_"+ind).val("");
    $("#"+prefix+"arg_op_resp_"+ind).val("");
    $("#"+prefix+"id_opcion_correcta_"+ind).attr("disabled", true);
    $("#"+prefix+"desc_op_resp_"+ind).attr("disabled", true);
    $("#"+prefix+"arg_op_resp_"+ind).attr("disabled", true);
}

function activa_op_preg(ind) {
    var prefix = "f"+$('#id_formato').val()+"_";
    $("#"+prefix+"activa_op_preg_"+ind).attr("hidden", true);
    $("#"+prefix+"desactiva_op_preg_"+ind).attr("hidden", false);
    $("#"+prefix+"conc_op_preg_"+ind).attr("disabled", false);
    $("#"+prefix+"prop_op_preg_"+ind).attr("disabled", false);
}

function desactiva_op_preg(ind) {
    var prefix = "f"+$('#id_formato').val()+"_";
    $("#"+prefix+"desactiva_op_preg_"+ind).attr("hidden", true);
    $("#"+prefix+"activa_op_preg_"+ind).attr("hidden", false);
    $("#"+prefix+"conc_op_preg_"+ind).val("");
    $("#"+prefix+"prop_op_preg_"+ind).val("");
    $("#"+prefix+"conc_op_preg_"+ind).attr("disabled", true);
    $("#"+prefix+"prop_op_preg_"+ind).attr("disabled", true);
}

jQuery(function($) {

    $('[data-rel=tooltip]').tooltip();

    $(".select2").css('width','200px').select2({allowClear:true})
        .on('change', function(e){
            $(this).closest('form').validate().element($(this));
            e.preventDefault();
        });


    $('#fuelux-wizard-container')
        .ace_wizard({
            //step: 2 //optional argument. wizard will jump to step "2" at first
            //buttons: '.wizard-actions:eq(0)'
        })
        .on('actionclicked.fu.wizard' , function(e, info){
            if(info.step == 1) {
                $('#actions-bottons').click(function(e){
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({'width': '100%'});
                    });
                    e.preventDefault();
                });
            } else if(info.step == 3){
                $("#finishMessage").attr("hidden", false);
                $("#validateMessage").attr("hidden", true);
            }
        })
        .on('finished.fu.wizard', function(e) {
            $("#id_estado").val(2);
            if(!isUpperCase()){
                $("#formulario").submit();
            }
            $("#finishMessage").attr("hidden", true);
            $("#validateMessage").attr("hidden", false);
        }).on('stepclicked.fu.wizard', function(e, info){
            $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({'width': '100%'});
                });
            //e.preventDefault();//this will prevent clicking and selecting steps
    });

    //jump to a step
    /**
     var wizard = $('#fuelux-wizard-container').data('fu.wizard')
     wizard.currentStep = 3;
     wizard.setState();
     */

    //determine selected step
    //wizard.selectedItem().step
});