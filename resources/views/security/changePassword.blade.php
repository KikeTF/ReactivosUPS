@extends('shared.templates.index')

@section('titulo', 'Usuario')
@section('subtitulo', 'Cambio de Contrase&ntilde;a')

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        $btnclose = route('index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="col-md-2 col-sm-2 col-xs-2" ></div>
        <div class="col-md-8 col-sm-8 col-xs-10" >

            <div class="form-group">
                {!! Form::label('old_password', 'Contrase&ntilde;a Actual:', ['class' => 'col-sm-4 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="clearfix">
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contrase&ntilde;a actual']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('new_password', 'Contrase&ntilde;a Nueva:', ['class' => 'col-sm-4 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="clearfix">
                        {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'Contrase&ntilde;a nueva']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('confirm_password', 'Confirmar Contrase&ntilde;a:', ['class' => 'col-sm-4 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="clearfix">
                        {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Confirmar contrase&ntilde;a']) !!}
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
