@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar reactivo')

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.reagents.update', $reagent->id],'method' => 'PUT']) !!}

    <?php
    $btnsave = 1;
    $btnrefresh = route('reagent.reagents.edit',$reagent->id);
    $btndelete = route('reagent.reagents.destroy', $reagent->id);
    $btnclose = route('reagent.reagents.index');
    ?>
    @include('shared.templates._formbuttons')

    <div id="accordion" class="accordion-style1 panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Informaci&oacute;n General
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse" id="collapseOne">
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

                    <div class="form-group">
                        {!! Form::label('desc_estado', 'Estado:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_estado', $reagent->desc_estado, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Informaci&oacute;n de Reactivo
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse in" id="collapseTwo">
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('desc_formato', 'Formato:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('desc_formato', $reagent->desc_formato, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('id_contenido_det', 'Tema:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_contenido_det', $contents, $reagent->id_contenido_det, ['class' => 'chosen-select form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('planteamiento', $reagent->planteamiento, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
                        </div>
                    </div>

                    @include('reagent.reagents._format')

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

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Comentarios
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse" id="collapseFour">
                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>Fecha</strong></td>
                                <td><strong>Creado por</strong></td>
                                <td><strong>Comentario</strong></td>
                                <td><strong>Estado Nuevo</strong></td>
                                <td><strong>Estado Anterior</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->fecha_creacion }}</td>
                                    <td>{{ $users[$comment->creado_por] }}</td>
                                    <td>{{ $comment->comentario }}</td>
                                    <td>{{ $states[$comment->id_estado_nuevo] }}</td>
                                    <td>{{ $states[$comment->id_estado_anterior] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
    <script type="text/javascript" src="{{ asset('scripts/reagent/reagents/common.js') }}"></script >
    <script type="text/javascript">
        $(window).load(function() {
            inputFileLoad();
        });
    </script>
@endpush