@extends('shared.templates.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Generaci&oacute;n de Examen')

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' =>
            'exam.exams.store',
            'method' => 'POST',
            'files' => true]) !!}

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
        </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
<script type="text/javascript" src="{{ asset('scripts/exam/exams/common.js') }}"></script>
<script type="text/javascript">
    jQuery(function($) {
        //$('.modal.aside').ace_aside();

        //$('#aside-inside-modal').addClass('aside').ace_aside({container: '#my-modal > .modal-dialog'});

        //$(document).one('ajaxloadstart.page', function(e) {
        //in ajax mode, remove before leaving page
        //    $('.modal.aside').remove();
        //    $(window).off('.aside')
        //});
    })
</script>
@endpush