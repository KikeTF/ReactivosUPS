@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo reactivo')

@push('specific-styles')
    <link rel="stylesheet" href="{{ asset('ace/css/select2.min.css') }}" />
@endpush

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.reagents.store','method' => 'POST']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="green" href="{{ route('reagent.reagents.create') }}">
                <i class='ace-icon fa fa-repeat bigger-110 green'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('reagent.reagents.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div class="widget-box">
        <div class="widget-header widget-header-blue widget-header-flat">
            <h4 class="widget-title lighter">Pasos para la creaci&oacute;n de reactivos</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div id="fuelux-wizard-container">
                    <div>
                        <ul class="steps">
                            <li data-step="1" class="active">
                                <span class="step">1</span>
                                <span class="title">Informaci&oacute;n General</span>
                            </li>

                            <li data-step="2">
                                <span class="step">2</span>
                                <span class="title">Informaci&oacute;n de Reactivo</span>
                            </li>

                            <li data-step="3">
                                <span class="step">3</span>
                                <span class="title">Informaci&oacute;n Complementaria</span>
                            </li>

                            <li data-step="4">
                                <span class="step">4</span>
                                <span class="title">Enviar a Aprobaci&oacute;n</span>
                            </li>
                        </ul>
                    </div>

                    <hr />

                    <div class="step-content pos-rel">
                        <div class="step-pane active" data-step="1">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_campus', $campuses, null, ['id' => 'id_campus', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_carrera', $careers, null, ['id' => 'id_carrera', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_mencion', 'Mención:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_mencion', $mentions, null, ['id' => 'id_mencion', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_materia', 'Materia:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_materia', $matters, null, ['id' => 'id_materia', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="step-pane" data-step="2">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_formato', 'Formato:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_formato', $formats, null, ['class' => 'form-control', 'placeholder' => 'Seleccione Formato'] ) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_contenido_det', 'Tema:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_contenido_det', $contents, null, ['class' => 'form-control', 'placeholder' => 'Seleccione Contenido']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('planteamiento', null, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                                    </div>
                                </div>

                                @include('reagent.reagents._format')

                            </div>
                        </div>

                        <div class="step-pane" data-step="3">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_campo', 'Campo de Conocimiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('id_campo', $fields, null, ['class' => 'form-control'] ) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('dificultad', 'Dificultad:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="dificultad" name="dificultad" class="form-control">
                                            <option value="B">Baja</option>
                                            <option value="M">Media</option>
                                            <option value="A">Alta</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('descripcion', 'Operaci&oacute;n Cognitiva:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('referencia', 'Referencia Bibliogr&aacute;fica:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('referencia', null, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-pane" data-step="4">
                            <div class="center">
                                <h3 class="green">Registro Exitoso!</h3>
                                De clic en finalizar para solicitar aprobaci&oacute;n
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                <div id="actions-bottons" class="wizard-actions">
                    <button class="btn btn-prev">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        Anterior
                    </button>

                    <button class="btn btn-success btn-next" data-last="Finalizar">
                        Siguiente
                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    </button>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
    <script src="{{ asset('ace/js/fuelux.wizard.min.js') }}"></script>
    <script src="{{ asset('ace/js/bootbox.min.js') }}"></script>
    <script src="{{ asset('ace/js/select2.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('scripts/reagent/reagents/create.js') }}"></script>
@endpush