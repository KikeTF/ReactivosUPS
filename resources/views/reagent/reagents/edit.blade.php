@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar reactivo')

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.reagents.update', $reagent->id],'method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('reagent.reagents.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div id="accordion" class="accordion-style1 panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Informaci&oacute;n General
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse in" id="collapseOne">
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('desc_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_campus', $reagent->desc_campus, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_carrera', $reagent->desc_carrera, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_mencion', 'Menci&oacute;n:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_mencion', $reagent->desc_mencion, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_materia', 'Materia:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_materia', $reagent->desc_materia, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('usr_responsable', 'Responsable:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('usr_responsable', $reagent->usr_responsable, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Informaci&oacute;n de Reactivo
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse" id="collapseTwo">
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('desc_formato', 'Formato:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_formato', $reagent->desc_formato, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('id_contenido_det', 'Tema:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('id_contenido_det', $contents, $reagent->id_contenido_det, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::textarea('planteamiento', $reagent->planteamiento, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12"><strong>Opciones de Pregunta:</strong></div>
                    </div>
                    <div class="form-group">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td></td>
                                <td><strong>Concepto</strong></td>
                                <td><strong>Propiedad</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reagentQuestions as $question)
                                <tr>
                                    <td>{{ $question->secuencia }}</td>
                                    <td>{{ $question->concepto }}</td>
                                    <td>{{ $question->propiedad }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12"><strong>Opciones de Respuesta:</strong></div>
                    </div>
                    <div class="form-group">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td></td>
                                <td><strong>Descripcion</strong></td>
                                <td><strong>Argumento</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reagentAnswers as $answer)
                                <tr>
                                    <td>{{ $answer->secuencia }}</td>
                                    <td>{{ $answer->descripcion }}</td>
                                    <td>{{ $answer->argumento }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Informaci&oacute;n Complementaria
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse" id="collapseThree">
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('id_campo', 'Campo de Conocimiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('id_campo', $fields, $reagent->id_campo, ['class' => 'form-control'] ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"><strong>Campo de Conocimiento:</strong></div>
                        <div class="col-sm-8">{{ $reagent->desc_campo }}</div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('descripcion', 'Operaci&oacute;n Cognitiva:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::textarea('descripcion', $reagent->descripcion, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('referencia', 'Referencia Bibliogr&aacute;fica:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::textarea('referencia', $reagent->referencia, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection