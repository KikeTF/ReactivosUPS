<script type="text/javascript">
    function getMentionsByCareer(formID, filter) {
        var formID = formID || document.forms[0].id;
        var objCarrera = $('#'+formID+' select[id=id_carrera]');
        var objMencion = $('#'+formID+' select[id=id_mencion]');
        var filtroMencion = filter || "{{ (isset($filters) ? $filters[2] : 0) }}";
        if (objCarrera.val() > 0) {
            $.ajax({
                url: "{{  route('general.matterscareers.mentions') }}",
                data: { "id_carrera" : objCarrera.val(), "id_mencion" : filtroMencion },
                async: false,
                success: function(result){
                    $('#'+formID+' div[id=listaMenciones]').empty();
                    $('#'+formID+' div[id=listaMenciones]').append(result['html']);
                }
            });
        }
        else {
            objMencion.find('option').remove().end()
                .append('<option value>-- No Aplica --</option>');
        }

    }
    function getMattersByCareer(formID){
        var formID = formID || document.forms[0].id;
        var objCampus = $('#'+formID+' select[id=id_campus]');
        var objCarrera = $('#'+formID+' select[id=id_carrera]');
        var objMateria = $('#'+formID+' select[id=id_materia]');
        var filtroMateria = "{{ (isset($filters) ? $filters[2] : 0) }}";
        if(objCampus.val() > 0 && objCarrera.val() > 0) {
            $.ajax({
                url: "{{  route('general.matterscareers.matters') }}",
                data: { "id_campus" : objCampus.val(), "id_carrera" : objCarrera.val(), "id_materia" : filtroMateria },
                async: false,
                success: function(result){
                    $('#'+formID+' div[id=listaMaterias]').empty();
                    $('#'+formID+' div[id=listaMaterias]').append(result['html']);
                    //$('#listaCarreras').prevUntil("div").removeClass('has-error');
                    $('#'+formID+' div[id=listaCarreras]').closest('.form-group').removeClass('has-error');
                    $("#id_carrera-error").remove();
                }
            });
        }
        else {
            objMateria.find('option').remove().end()
                .append('<option value>-- Seleccione Materia --</option>');
        }
    }
    function getCareersByCampus(formID, filter) {
        var formID = formID || document.forms[0].id;
        var objCampus = $('#'+formID+' select[id=id_campus]');
        var objCarrera = $('#'+formID+' select[id=id_carrera]');
        var filtroCarrera = filter || "{{ (isset($filters) ? $filters[1] : 0) }}";
        if(objCampus.val() > 0) {
            $.ajax({
                url: "{{  route('general.matterscareers.careers') }}",
                data: { "id_campus" : objCampus.val(), "id_carrera" : filtroCarrera },
                async: false,
                success: function(result){
                    $('#'+formID+' div[id=listaCarreras]').empty();
                    $('#'+formID+' div[id=listaCarreras]').append(result['html']);
                }
            });
        }
        else {
            objCarrera.find('option').remove().end()
                .append('<option value>-- Seleccione Carrera --</option>');
        }
    }
    function getContentsByMatter(formID) {
        var formID = formID || document.forms[0].id;
        var objCampus = $('#'+formID+' select[id=id_campus]');
        var objCarrera = $('#'+formID+' select[id=id_carrera]');
        var objMateria = $('#'+formID+' select[id=id_materia]');
        if(objMateria.val() > 0) {
            $.ajax({
                url: "{{  route('general.matterscareers.contents') }}",
                data: { "id_campus" : objCampus.val(), "id_carrera" : objCarrera.val(), "id_materia" : objMateria.val() },
                async: false,
                success: function(result){
                    $('#listaContenidos').empty();
                    $('#listaContenidos').append(result['html']);
                    $('#referencia').val(result['bibliografia']);
                    $("#id_contenido_det").chosen().change();
                    $("#listaMaterias").closest('.form-group').removeClass('has-error');
                    $("#id_materia-error").remove();
                    $("#referencia").closest('div').closest('div').closest('.form-group').removeClass('has-error');
                    $("#referencia-error").remove();
                }
            });
        }
    }
</script>