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
            <h4 class="widget-title lighter">Pasos para la creaci&oacute;n de ractivos</h4>
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
                            <h3 class="lighter block green">Enter the following information</h3>
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_campus" name="id_campus" class="form-control">
                                            @foreach($campuses as $camp)
                                                <option value="{{ $camp->id }}">{{ $camp->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_carrera" name="id_carrera" class="form-control">
                                            @foreach($careers as $career)
                                                <option value="{{ $career->id }}">{{ $career->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_mencion', 'Mención:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_mencion" name="id_mencion" class="form-control">
                                            @foreach($mentions as $mention)
                                                <option value="{{ $mention->id }}">{{ $mention->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_materia', 'Materia:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_materia" name="id_materia" class="form-control">
                                            @foreach($matters as $matter)
                                                <option value="{{ $matter->id }}">{{ $matter->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('nivel', 'Nivel:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('nivel', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('estado', 'A', true) !!}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-pane" data-step="2">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_contenido_det', 'Tema:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_contenido_det" name="id_contenido_det" class="form-control">
                                            @foreach($contents as $content)
                                                <option value="{{ $content->id }}">{{ $content->capitulo." ".$content->tema }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('planteamiento', null, ['class' => 'form-control', 'size' => '100%x5'])!!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_formato', 'Formato:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_formato" name="id_formato" class="form-control">
                                            @foreach($formats as $format)
                                                <option value="{{ $format->id }}">{{ $format->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('id_opcion_resp', 'Opciones de Respuesta:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                                            <table id="opcion_resp" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                                                @for ($i = 1; $i <= $parameters->nro_opciones_resp_max; $i++)
                                                    <tr>
                                                        <td>
                                                            {!! Form::text('desc_op_resp_'.$i, null, [
                                                                    'id' => 'desc_op_resp_'.$i,
                                                                    'class' => 'form-control',
                                                                    'placeholder' => 'Descripción de respuesta.',
                                                                    'style' => 'height: 25px;',
                                                                    ($i > $parameters->nro_opciones_resp_min) ? 'disabled' : ''
                                                            ]) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::text('arg_op_resp_'.$i, null, [
                                                                    'id' => 'arg_op_resp_'.$i,
                                                                    'class' => 'form-control',
                                                                    'placeholder' => 'Argumento de respuesta.',
                                                                    'style' => 'height: 25px;',
                                                                     ($i > $parameters->nro_opciones_resp_min) ? 'disabled' : ''
                                                            ]) !!}
                                                        </td>
                                                        <td>
                                                            <div class="hidden-sm hidden-xs action-buttons">
                                                                <a class="green" href="#" title="Editar">
                                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                                </a>
                                                                <a class="blue" href="#" title="Borrar">
                                                                    <i class="ace-icon fa fa-eraser bigger-120"></i>
                                                                </a>
                                                            </div>
                                                            <div class="hidden-md hidden-lg">
                                                                <div class="inline pos-rel">
                                                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                        <li>
                                                                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Editar">
                                                                                <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Borrar">
                                                                                <span class="blue"><i class="ace-icon fa fa-eraser bigger-120"></i></span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-pane" data-step="3">
                            <div>
                                <div class="form-group">
                                    {!! Form::label('id_campo', 'Campo de Conocimiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        <select id="id_campo" name="id_campo" class="form-control">
                                            @foreach($fields as $field)
                                                <option value="{{ $field->id }}">{{ $field->nombre}}</option>
                                            @endforeach
                                        </select>
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
                                    {!! Form::label('descripcion', 'Operacion Cognitiva:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'size' => '100%x5'])!!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('referencia', 'Referencia Bibliográfica:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('referencia', null, ['class' => 'form-control', 'size' => '100%x5'])!!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-pane" data-step="4">
                            <div class="center">
                                <h3 class="green">Congrats!</h3>
                                Your product is ready to ship! Click finish to continue!
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

                    <button class="btn btn-success btn-next" data-last="Finish">
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