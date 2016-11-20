$('#id_formato').on('change', function() {
    var id = "f"+this.value+"_";
    for(i = 1; i <= $("#format_count").val(); i++){
        document.getElementById("reagent_format_"+i).style.display = 'none';
        $("#reagent_format_"+i).find('input, textarea, button, select').attr('disabled','disabled');
    }
    document.getElementById("reagent_format_"+this.value).style.display = 'block';
    $("#reagent_format_"+this.value).find('input, textarea, button, select').prop('disabled', false);

    for(i = 1; i <= $("#"+id+"format_resp_max").val(); i++){
        if(i > $("#"+id+"format_resp_min").val()){
            $("#"+id+"desc_op_resp_"+i).attr('disabled','disabled');
            $("#"+id+"arg_op_resp_"+i).attr('disabled','disabled');
        }
    }

    for(i = 1; i <= $("#"+id+"format_preg_max").val(); i++){
        if(i > $("#"+id+"format_preg_min").val()){
            $("#"+id+"conc_op_preg_"+i).attr('disabled','disabled');
            $("#"+id+"prop_op_preg_"+i).attr('disabled','disabled');
        }
    }
});

function activa_op_resp(ind) {
    var id = "f"+$('#id_formato').val()+"_";
    $("#"+id+"activa_op_resp_"+ind).attr("hidden", true);
    $("#"+id+"desactiva_op_resp_"+ind).attr("hidden", false);
    $("#"+id+"id_opcion_correcta_"+ind).attr("disabled", false);
    $("#"+id+"desc_op_resp_"+ind).attr("disabled", false);
    $("#"+id+"arg_op_resp_"+ind).attr("disabled", false);
}

function desactiva_op_resp(ind) {
    var id = "f"+$('#id_formato').val()+"_";
    $("#"+id+"desactiva_op_resp_"+ind).attr("hidden", true);
    $("#"+id+"activa_op_resp_"+ind).attr("hidden", false)
    $("#"+id+"desc_op_resp_"+ind).val("");
    $("#"+id+"arg_op_resp_"+ind).val("");
    $("#"+id+"id_opcion_correcta_"+ind).attr("disabled", true);
    $("#"+id+"desc_op_resp_"+ind).attr("disabled", true);
    $("#"+id+"arg_op_resp_"+ind).attr("disabled", true);
}

function activa_op_preg(ind) {
    var id = "f"+$('#id_formato').val()+"_";
    $("#"+id+"activa_op_preg_"+ind).attr("hidden", true);
    $("#"+id+"desactiva_op_preg_"+ind).attr("hidden", false);
    $("#"+id+"conc_op_preg_"+ind).attr("disabled", false);
    $("#"+id+"prop_op_preg_"+ind).attr("disabled", false);
}

function desactiva_op_preg(ind) {
    var id = "f"+$('#id_formato').val()+"_";
    $("#"+id+"desactiva_op_preg_"+ind).attr("hidden", true);
    $("#"+id+"activa_op_preg_"+ind).attr("hidden", false)
    $("#"+id+"conc_op_preg_"+ind).val("");
    $("#"+id+"prop_op_preg_"+ind).val("");
    $("#"+id+"conc_op_preg_"+ind).attr("disabled", true);
    $("#"+id+"prop_op_preg_"+ind).attr("disabled", true);
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
                    e.preventDefault();
                });

                //e.preventDefault();
            }
        })
        .on('finished.fu.wizard', function(e) {
            bootbox.dialog({
                message: "Thank you! Your information was successfully saved!",
                buttons: {
                    "success" : {
                        "label" : "OK",
                        "className" : "btn-sm btn-primary"
                    }
                }
            });
        }).on('stepclick.fu.wizard', function(e){
        //e.preventDefault();//this will prevent clicking and selecting steps
    });

    /*

    */


    //jump to a step
    /**
     var wizard = $('#fuelux-wizard-container').data('fu.wizard')
     wizard.currentStep = 3;
     wizard.setState();
     */

    //determine selected step
    //wizard.selectedItem().step



    //hide or show the other form which requires validation
    //this is for demo only, you usullay want just one form in your application





    //$('#modal-wizard-container').ace_wizard();
    //$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');


    /**
     $('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
                $(this).closest('form').validate().element($(this));
            });

     $('#mychosen').chosen().on('change', function(ev) {
                $(this).closest('form').validate().element($(this));
            });
     */

    /*
    $(document).one('ajaxloadstart.page', function(e) {
        //in ajax mode, remove remaining elements before leaving page
        $('[class*=select2]').remove();
    });
    */
})

