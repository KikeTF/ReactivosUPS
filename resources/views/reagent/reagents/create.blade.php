@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo reactivo')

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.reagents.store','method' => 'POST']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('reagent.reagents.create');
    $btnclose = route('reagent.reagents.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="widget-box">
        <div class="widget-header widget-header-blue widget-header-flat">
            <h4 class="widget-title lighter">Pasos para la creaci&oacute;n de reactivos</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div id="fuelux-wizard-container">
                    <div>
                        <ul id="actions-steps" class="steps">
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
                                    <div class="col-sm-7">
                                        {!! Form::select('id_campus', $campuses, null, ['id' => 'id_campus', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        {!! Form::select('id_carrera', $careers, null, ['id' => 'id_carrera', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_mencion', 'Mención:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        {!! Form::select('id_mencion', $mentions, null, ['id' => 'id_mencion', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_materia', 'Materia:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        {!! Form::select('id_materia', $matters, null, ['id' => 'id_materia', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="step-pane" data-step="2">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_formato', 'Formato:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                                    <div class="col-sm-9">
                                        <div class="clearfix">
                                        {!! Form::select('id_formato', $formats, null, ['class' => 'form-control', 'placeholder' => '-- Seleccione Formato --', 'required'] ) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_contenido_det', 'Tema:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                                    <div class="col-sm-9">
                                        <select name="id_contenido_det" id="id_contenido_det" class="chosen-select form-control" data-placeholder="-- Seleccione Contenido --" required>
                                            <option value=""></option>
                                            @foreach($contents as $content)
                                                <option value="{{ $content->id }}">{{ $content->ContentDescription }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                                    <div class="col-sm-9">
                                        <div class="clearfix">
                                            {!! Form::textarea('planteamiento', null, ['id' => 'planteamiento', 'class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;', 'required'])!!}
                                        </div>
                                    </div>
                                </div>

                                @include('reagent.reagents._format')

                            </div>
                        </div>

                        <div class="step-pane" data-step="3">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_campo', 'Campo de Conocimiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        <div class="clearfix">
                                        {!! Form::select('id_campo', $fields, null, ['class' => 'form-control', 'placeholder' => '-- Seleccione Campo de Conocimiento --', 'required'] ) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('dificultad', 'Dificultad:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        <div class="clearfix">
                                            <select id="dificultad" name="dificultad" class="form-control" required>
                                                <option value="">-- Seleccione Dificultad --</option>
                                                <option value="B">Baja</option>
                                                <option value="M">Media</option>
                                                <option value="A">Alta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('descripcion', 'Operaci&oacute;n Cognitiva:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('referencia', 'Referencia Bibliogr&aacute;fica:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-7">
                                        <div class="clearfix">
                                            {!! Form::textarea('referencia', null, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;', 'required'])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-pane" data-step="4">
                            <div class="center">
                                <div id="finishMessage" class="well"><h4>Presione <strong class="green">"Finalizar"</strong> para enviar a aprobaci&oacute;n!</h4></div>
                                <div hidden id="validateMessage" class="well"><h4 class="red">Registro incompleto. Por favor verificar!</h4></div>
                                {!! Form::text('id_estado', 1, ['id' => 'id_estado', 'hidden'] ) !!}
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
    <script type="text/javascript" src="{{ asset('scripts/reagent/reagents/create.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/reagent/reagents/common.js') }}"></script>
@endpush
