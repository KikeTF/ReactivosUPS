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

                $('#finishMessage').empty();
                $('#finishMessage').append('<h4>Presione <strong class="green">"Finalizar"</strong> para solicitar aprobaci&oacute;n!</h4>');
            }
        })
        .on('finished.fu.wizard', function(e) {
            $("#id_estado").val(2);
            if(!isUpperCase()){
                clearErrors();
                $("#formulario").submit();
            }
            //$("#finishMessage").attr("hidden", true);
            //$("#validateMessage").attr("hidden", false);
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