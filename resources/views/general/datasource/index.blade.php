@extends('shared.templates.index')

@section('titulo', 'General')
@section('subtitulo', 'Importaci&oacute;n de CSV')

@section('contenido')

    <button type="button" class="btn btn-primary" onclick="importData()">Importar</button>

    <div class="pull-right center spinner-preview" id="spinner-preview"></div>

    <script type="text/javascript">


        function importData(){
            spinnerLoadingStart();
            $.ajax({
                type: 'GET',
                url: "{{ Route("general.datasource.import") }}",
                data: null,
                dataType: "json",
                async: true,
                cache: false,
                error: function (e) {
                    console.log(e);
                },
                success: function (result) {
                    if(result.valid){
                        window.location.replace("{{ Route("general.datasource.index") }}");
                    }
                },
                complete: function () {
                    spinnerLoadingStop();
                }
            });
        }
    </script>
@endsection
