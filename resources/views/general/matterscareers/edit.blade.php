@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Editar par&aacute;metros de materia: '.$mattercareer->matter->descripcion)

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => ['general.matterscareers.update', $mattercareer->id],'method' => 'PUT', 'files' => true]) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('general.matterscareers.edit',$mattercareer->id);
    $btndelete = route('general.matterscareers.destroy', $mattercareer->id);
    $btnclose = route('general.matterscareers.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('desc_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_campus', $mattercareer->careerCampus->campus->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('desc_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_carrera', $mattercareer->careerCampus->career->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_area', '&Aacute;rea:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::select('id_area', $areasList, $mattercareer->id_area, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('desc_materia', 'Materia:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_materia', $mattercareer->matter->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nivel', 'Nivel:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('nivel', $mattercareer->nivel, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    @if($mentionsList->count() > 0)
    <div class="form-group">
        {!! Form::label('id_mencion', 'Menci&oacute;n:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::select('id_mencion', $mentionsList, $mattercareer->id_mencion, ['class' => 'form-control']) !!}
        </div>
    </div>
    @endif

    <div class="form-group">
        {!! Form::label('nro_reactivos_mat', 'No. de Reactivos Entregables:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','nro_reactivos_mat', $mattercareer->nro_reactivos_mat,
                    ['min'=>'0', 'max'=>'50','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 0; M&aacute;ximo 50', 'required']
                ) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nro_reactivos_exam', 'No. de Reactivos en Examen:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','nro_reactivos_exam', $mattercareer->nro_reactivos_exam,
                    ['min'=>'0', 'max'=>'50','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 0; M&aacute;ximo 50','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('aplica_examen', '¿Aplica Examen?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('aplica_examen', $mattercareer->aplica_examen, ($mattercareer->aplica_examen == 'S') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', $mattercareer->estado, ($mattercareer->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('archivo_contenido', 'Material de Apoyo:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-6">
            {!! Form::file('archivo_contenido', ['id' => 'archivo_contenido', 'class' => 'input-file form-control']) !!}
        </div>
        <div class="col-sm-2">
            <button onclick="location.href='{{ route('general.matterscareers.download', $mattercareer->id) }}'; return false;"
                    class="btn btn-sm btn-primary pull-left" {{ $mattercareer->archivo_contenido == 'S' ? '' : 'disabled' }} >
                <i class="ace-icon fa fa-download bigger-110" aria-hidden="true"></i> Descargar Archivo
            </button>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
    <script type="text/javascript">
        //function inputFileLoad(){
            $('.input-file').ace_file_input({
                no_file:'Cargar archivo PFD...',
                btn_choose:'Seleccionar',
                btn_change:'Cambiar',
                droppable:false,
                onchange:null,
                thumbnail:false, //| true | large
                whitelist:'pdf',
                allowExt: ["pdf"]
                //blacklist:'exe|php'
                //onchange:''
                //
            });
        //}
    </script>
@endpush