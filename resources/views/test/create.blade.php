@extends('test.template')

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => 'test.store',
            'method' => 'POST']) !!}

        <div class="page-header">
            <h4 style="padding: 0; margin: 0;">Complete la informaci&oacute;n:</h4>
        </div>

        {!! Form::hidden('NewTest', 1) !!}

        <div class="row">
            <div class="col-md-4 col-sm-3" ></div>
            <div class="col-md-4 col-sm-5" >
                <div class="form-group">
                    {!! Form::label('id_sede', 'Sede:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div id="listaSedes" class="col-sm-10">
                        <div class="clearfix">
                            @include("shared.optionlists._locationslist", ['requerido' => '1'])
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div id="listaCampus" class="col-sm-10">
                        <div class="clearfix">
                            @include("shared.optionlists._campuslist", ['requerido' => '1'])
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div id="listaCarreras" class="col-sm-10">
                        <div class="clearfix">
                            @include("shared.optionlists._careerslist", ['requerido' => '1'])
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('id_mencion', 'Mencion:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div id="listaMenciones" class="col-sm-10">
                        <div class="clearfix">
                            @include('shared.optionlists._mentionslist', ['requerido' => '1'])
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('cedula', 'Cedula:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div class="col-sm-10">
                        <div class="clearfix">
                            {!! Form::text('cedula', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('nombres', 'Nombres:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div class="col-sm-10">
                        <div class="clearfix">
                            {!! Form::text('nombres', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('apellidos', 'Apellidos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div class="col-sm-10">
                        <div class="clearfix">
                            {!! Form::text('apellidos', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('correo', 'Correo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                    <div class="col-sm-10">
                        <div class="clearfix">
                            {!! Form::text('correo', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <div id="actions-bottons" class="pull-right">
                            <button type="submit" class="btn btn-success btn-next">
                                Siguiente
                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
<script type="text/javascript">
    function getCampusByLocation() {
        getLists('#listaCampus', 'campus');
    }
    function getCareersByCampus() {
        getLists('#listaCarreras','carrera');
    }
    function getMattersByCareer(){}
    function getMentionsByCareer(){
        getLists('#listaMenciones','mencion');
    }
    function getLists(strList, lista) {
        var data = {
            "lista" : lista,
            "id_sede": $("#id_sede").val(),
            "id_campus" : $("#id_campus").val(),
            "id_carrera" : $("#id_carrera").val()
        }

        $.ajax({
            url: "{{  route('test.lists') }}",
            data: data,
            async: false,
            success: function(result){
                $(strList).empty();
                $(strList).append(result['html']);
            }
        });
    }
</script>
@endpush