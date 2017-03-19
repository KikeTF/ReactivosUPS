<script type="text/javascript">
    function getMattersByCareer(){
        url = "{{  route('general.matterscareers.matters') }}";
        $.get(url, {"id_campus" : $("#id_campus").val(), "id_carrera" : $("#id_carrera").val()}, function(data) {
            $('#listaMaterias').empty();
            $('#listaMaterias').append(data['html']);
        });
    }
    function getCareersByCampus() {
        url = "{{  route('general.matterscareers.careers') }}";
        $.get(url, {"id_campus" : $("#id_campus").val()}, function(data) {
            $('#listaCarreras').empty();
            $('#listaCarreras').append(data['html']);
        });
    }
</script>