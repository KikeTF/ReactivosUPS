@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar reactivo')

@push('specific-styles')
    {!! HTML::style('ace/css/colorbox.min.css') !!}
@endpush

@section('contenido')

    {!! Form::open(['id' => 'formulario',
        'class' => 'form-horizontal',
        'role' => 'form',
        'route' => ['reagent.reagents.update', $reagent->id],
        'method' => 'PUT',
        'files' => true]) !!}

    <?php
    $btnsave = 1;
    $btnrefresh = route('reagent.reagents.edit',$reagent->id);
    $btndelete2 = 1;
    $btnclose = route('reagent.reagents.index');
    $btnreply = 1;
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
                            {!! Form::text('desc_campus', $reagent->distributive->matterCareer->careerCampus->campus->descripcion, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_carrera', $reagent->distributive->matterCareer->careerCampus->career->descripcion, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_mencion', 'Menci&oacute;n:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_mencion', $reagent->distributive->matterCareer->mention->descripcion, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_materia', 'Materia:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_materia', $reagent->distributive->matterCareer->matter->descripcion, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    {!! Form::hidden('id_campus', $reagent->distributive->matterCareer->careerCampus->campus->id, ['id' => 'id_campus']) !!}
                    {!! Form::hidden('id_carrera', $reagent->distributive->matterCareer->careerCampus->career->id, ['id' => 'id_carrera']) !!}
                    {!! Form::hidden('id_materia', $reagent->distributive->matterCareer->matter->id, ['id' => 'id_materia']) !!}
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-3">
                            <button onclick="downloadContent('{{  route('reagent.reagents.mattercontent') }}', '{{ route('reagent.reagents.mattercontentdownload') }}'); return false;" class="btn btn-sm btn-primary pull-left">
                                <i class="ace-icon fa fa-download bigger-110" aria-hidden="true"></i> Descargar Contenido
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('usr_responsable', 'Responsable:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('usr_responsable', $reagent->user->FullName, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_estado', 'Estado:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('desc_estado', $reagent->state->descripcion, ['class' => 'form-control', 'readonly']) !!}
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
                            {!! Form::text('desc_formato', $reagent->format->nombre, ['class' => 'form-control', 'readonly']) !!}
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

                    {!! Form::hidden('imagen', $reagent->imagen, ['id' => 'imagen']) !!}
                    @if($reagent->imagen == 'S')
                    <div id="image-container" class="form-group">
                        <div class="col-sm-12 col-sm-offset-2">
                            <ul class="ace-thumbnails clearfix">
                                <li style="border: 1px solid #d5d5d5 !important;">
                                    <a href="{{ route('reagent.reagents.image', $reagent->id) }}" data-rel="colorbox">
                                        <img class="img-responsive" src="{{ route('reagent.reagents.image', $reagent->id) }}" style="max-width: 300px; width: 100%;" />
                                    </a>
                                    <div class="tools tools-bottom">
                                        <a id="no-image"><i class="ace-icon fa fa-times red" style="cursor: pointer;"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif

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
                        {!! Form::label('dificultad', 'Dificultad:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('dificultad', ['B' => 'Baja', 'M' => 'Media', 'A' => 'Alta'], $reagent->dificultad, ['class' => 'form-control'] ) !!}
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
                                <td><strong>Estado</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reagent->comments->sortByDesc('id') as $comment)
                                <tr>
                                    <td>{{ $comment->fecha_creacion }}</td>
                                    <td>{{ $comment->user->FullName }}</td>
                                    <td>{{ $comment->comentario }}</td>
                                    <td>{{ $comment->state->descripcion }}</td>
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
    {!! HTML::script('ace/js/jquery.colorbox.min.js') !!}
    {!! HTML::script('scripts/reagent/reagents/common.js') !!}
    <script type="text/javascript">
        $(window).load(function() {
            inputFileLoad();
            imagePropertiesLoad();
        });

        $("#btn-reenviar").on('click', function() {
            bootbox.prompt({
                title: "Ingrese sus comentarios...",
                inputType: 'textarea',
                buttons: {
                    'confirm': {
                        label: 'Enviar',
                        className: 'btn-info'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("reagent.approvals.comment", $reagent->id) }}",
                            data: {'comentario':result, 'id_estado':2},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("reagent.reagents.show", $reagent->id) }}");
                                }
                                else {
                                    alert('Error');
                                }
                            }
                        });
                    }
                }
            });
        });

        $("#btn-eliminar").on('click', function() {
            bootbox.prompt({
                title: "Ingrese sus comentarios...",
                inputType: 'textarea',
                buttons: {
                    'confirm': {
                        label: 'Eliminar',
                        className: 'btn-danger'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("reagent.approvals.comment", $reagent->id) }}",
                            data: {'comentario':result, 'id_estado':7},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("reagent.reagents.index") }}");
                                }
                                else {
                                    alert('Error');
                                }
                            }
                        });
                    }
                }
            });
        });

        $("#no-image").on('click', function() {
            $("#imagen").val("N");
            $("#image-container").attr('hidden', true)
        })
    </script>
@endpush