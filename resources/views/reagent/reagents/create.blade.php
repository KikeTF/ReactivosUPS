@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo reactivo')

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

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    <select id="id_campus" name="id_campus" class="form-control">
                        @foreach($campuses as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    <select id="id_carrera" name="id_carrera" class="form-control">
                        @foreach($careers as $career)
                            <option value="{{ $career->id }}">{{ $career->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('id_mencion', 'Mención:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    <select id="id_mencion" name="id_mencion" class="form-control">
                        @foreach($mentions as $mention)
                            <option value="{{ $mention->id }}">{{ $mention->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('id_materia', 'Materia:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    <select id="id_materia" name="id_materia" class="form-control">
                        @foreach($matters as $matter)
                            <option value="{{ $matter->id }}">{{ $matter->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('nivel', 'Nivel:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    {!! Form::text('nivel', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="form-group">
        {!! Form::label('id_contenido_det', 'Tema:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select id="id_contenido_det" name="id_contenido_det" class="form-control">
                @foreach($contents as $content)
                    <option value="{{ $content->id }}">{{ $content->capitulo." ".$content->tema }}</option>
                @endforeach
            </select>
        </div>
    </div>
    </div>
    <div class="form-group">
        {!! Form::label('id_formato', 'Formato:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select id="id_formato" name="id_formato" class="form-control">
                @foreach($formats as $format)
                    <option value="{{ $format->id }}">{{ $format->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_campo', 'Campo de Conocimiento:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select id="id_campo" name="id_campo" class="form-control">
                @foreach($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('dificultad', 'Dificultad:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select id="dificultad" name="dificultad" class="form-control">
                <option value="B">Baja</option>
                <option value="M">Media</option>
                <option value="A">Alta</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::textarea('planteamiento', null, ['class' => 'form-control', 'size' => '100%x5'])!!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Operacion Cognitiva:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'size' => '100%x5'])!!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('referencia', 'Referencia Bibliográfica:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::textarea('referencia', null, ['class' => 'form-control', 'size' => '100%x5'])!!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', 'A', true) !!}
                </label>
            </div>

        </div>
    </div>



    {!! Form::close() !!}

@endsection