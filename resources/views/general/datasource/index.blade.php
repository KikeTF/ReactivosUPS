@extends('shared.templates.index')

@section('titulo', 'General')
@section('subtitulo', 'Importaci&oacute;n de CSV')

@section('contenido')

    <div>Prueba</div>
    <button type="button" class="btn btn-primary" onclick="importData()">Importar</button>

    <script type="text/javascript">

        function importData(){
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
                success: function () {
                    console.log("ok");
                }
            });
        }
    </script>
@endsection
