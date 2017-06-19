<script type="text/javascript">
    function getMentionsByCareer(){
        filtroMencion = "{{ (isset($filters) ? $filters[2] : 0) }}";
        $.ajax({
            url: "{{  route('general.matterscareers.mentions') }}",
            data: { "id_carrera" : $("#id_carrera").val(), "id_mencion" : filtroMencion },
            async: false,
            success: function(result){
                $('#listaMenciones').empty();
                $('#listaMenciones').append(result['html']);
            }
        });
    }
    function getMattersByCareer(){
        filtroMateria = "{{ (isset($filters) ? $filters[2] : 0) }}";
        if($("#id_campus").val() > 0 && $("#id_carrera").val() > 0)
        {
            $.ajax({
                url: "{{  route('general.matterscareers.matters') }}",
                data: { "id_campus" : $("#id_campus").val(), "id_carrera" : $("#id_carrera").val(), "id_materia" : filtroMateria },
                async: false,
                success: function(result){
                    $('#listaMaterias').empty();
                    $('#listaMaterias').append(result['html']);
                    //$('#listaCarreras').prevUntil("div").removeClass('has-error');
                    $("#listaCarreras").closest('.form-group').removeClass('has-error');
                    $("#id_carrera-error").remove();
                }
            });
        }
    }
    function getCareersByCampus() {
        filtroCarrera = "{{ (isset($filters) ? $filters[1] : 0) }}";
        if($("#id_campus").val() > 0)
        {
            $.ajax({
                url: "{{  route('general.matterscareers.careers') }}",
                data: { "id_campus" : $("#id_campus").val(), "id_carrera" : filtroCarrera },
                async: false,
                success: function(result){
                    $('#listaCarreras').empty();
                    $('#listaCarreras').append(result['html']);
                }
            });
        }
    }
    function getContentsByMatter() {
        if($("#id_materia").val() > 0)
        {
            $.ajax({
                url: "{{  route('general.matterscareers.contents') }}",
                data: { "id_campus" : $("#id_campus").val(), "id_carrera" : $("#id_carrera").val(), "id_materia" : $("#id_materia").val() },
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