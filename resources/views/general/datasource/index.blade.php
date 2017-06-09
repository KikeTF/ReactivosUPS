@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Importaci&oacute;n de CSV')

@section('contenido')

    {!! Form::open(['id' => 'formulario',
        'class' => 'form-horizontal',
        'role' => 'form',
        'route' => 'general.datasource.import',
        'method' => 'POST',
        'files' => true]) !!}

        <br/>
        <br/>
        <br/>
        <br/>
        <div class="form-group">
            {!! Form::label('csvFile','Subir Archivo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-7">
                {!! Form::file('csvFile', ['id' => 'csvFile', 'class' => 'input-file form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10" align="center">
                <button type="button" class="btn btn-primary" onclick="importData()">Importar</button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10" align="center">
                <div class="pull-right center spinner-preview" id="spinner-preview"></div>
            </div>
        </div>

    {!! Form::close() !!}

    <script type="text/javascript">
        function importData(){
            //alert("F");
            //var file = document.getElementById("filepath");
            //alert("OK");
            spinnerLoadingStart();
            $("#formulario").submit();
            /*
            $.ajax({
                type: 'GET',
                url: "{{ Route("general.datasource.import") }}",
                data: { 'file' : $("#filepath").val()}, //$("#filepath").val()
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
            */
        }
    </script>
@endsection

@push('specific-script')
    <script type="text/javascript" src="{{ asset('scripts/general/datasource/index.js') }}"></script>
@endpush
