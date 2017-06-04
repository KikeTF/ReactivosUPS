@extends('shared.templates.index')

@section('titulo')
    <i class="ace-icon fa fa-key"></i><span> Cambio de Contrase&ntilde;a</span>
@endsection
@section('subtitulo', Auth::user()->FullName)

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form', 'route' => 'security.changePassword', 'method' => 'POST']) !!}

        <?php
        $btnclose = route('index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="col-md-2 col-sm-2 col-xs-12" ></div>
        <div class="col-md-8 col-sm-8 col-xs-12" >
            <div class="form-group">
                {!! Form::label('old_password', 'Contrase&ntilde;a Actual:', ['class' => 'col-sm-4 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="clearfix">
                        {!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => 'Contrase&ntilde;a actual', 'required']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('new_password', 'Contrase&ntilde;a Nueva:', ['class' => 'col-sm-4 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="clearfix">
                        {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'Contrase&ntilde;a nueva', 'minlength' => '6', 'maxlength' => '16', 'required']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('confirm_password', 'Confirmar Contrase&ntilde;a:', ['class' => 'col-sm-4 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="clearfix">
                        {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Confirmar contrase&ntilde;a', 'minlength' => '6', 'maxlength' => '16', 'required']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-11">
                    <button class="btn btn-primary pull-right" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Guardar
                    </button>
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@endsection
