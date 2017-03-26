<script type="text/javascript">
    function getMattersByCareer(){
        filtroMateria = "{{ (isset($filters) ? $filters[2] : 0) }}";
        $.ajax({
            url: "{{  route('general.matterscareers.matters') }}",
            data: { "id_campus" : $("#id_campus").val(), "id_carrera" : $("#id_carrera").val(), "id_materia" : filtroMateria },
            async: false,
            success: function(result){
                $('#listaMaterias').empty();
                $('#listaMaterias').append(result['html']);
            }
        });
    }
    function getCareersByCampus() {
        filtroCarrera = "{{ (isset($filters) ? $filters[1] : 0) }}";
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
    function getContentsByMatter() {
        $.ajax({
            url: "{{  route('general.matterscareers.contents') }}",
            data: { "id_campus" : $("#id_campus").val(), "id_carrera" : $("#id_carrera").val(), "id_materia" : $("#id_materia").val() },
            async: false,
            success: function(result){
                $('#listaContenidos').empty();
                $('#listaContenidos').append(result['html']);
            }
        });
    }
</script>