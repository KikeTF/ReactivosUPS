
function activa_op_resp(id) {
    $("#activa_op_resp_"+id).attr("hidden", true);
    $("#desactiva_op_resp_"+id).attr("hidden", false);
    $("#id_opcion_correcta_"+id).attr("disabled", false);
    $("#desc_op_resp_"+id).attr("disabled", false);
    $("#arg_op_resp_"+id).attr("disabled", false);

}

function desactiva_op_resp(id) {
    $("#desactiva_op_resp_"+id).attr("hidden", true);
    $("#activa_op_resp_"+id).attr("hidden", false)
    $("#desc_op_resp_"+id).val("");
    $("#arg_op_resp_"+id).val("");
    $("#id_opcion_correcta_"+id).attr("disabled", true);
    $("#desc_op_resp_"+id).attr("disabled", true);
    $("#arg_op_resp_"+id).attr("disabled", true);
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
