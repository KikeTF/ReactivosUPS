@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Nueva parametrizaci&oacute;n para ex&aacute;menes')

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => 'exam.parameters.store', 'method' => 'POST']) !!}

    <?php
    $defaultInst = "<ol>\n	<li>\n		El siguiente es una simulación del examen complexivo de la Carrera de Ingeniería de Sistemas de la Universidad Politécnica Salesiana Sede Guayaquil, las preguntas que se encuentran en el mismo solo son una base de referencia, no significa que el examen real contendrá las mismas preguntas.\n	</li>\n	<div class=\"space-6\"></div>\n	<li>\n		Al igual que el examen real esta simulación contiene:\n		<ol type=\"a\">\n			<li>100 preguntas de tipo reactivo.</li>\n			<li>Podrá regresar para revisar las preguntas.</li>\n			<li>Contará con un reloj con cuenta regresiva.</li>\n			<li>El tiempo máximo es de 4 horas.</li>\n		</ol>\n	</li>\n	<div class=\"space-6\"></div>\n	<li>\n		Al terminar la simulación le presentará un resultado con el número de aciertos.\n	</li>\n	<div class=\"space-6\"></div>\n	<li>\n		El objetivo de la simulación es proporcionar al estudiante una herramienta para medir el tiempo que le tomará responder los 100 reactivos.\n	</li>\n	<div class=\"space-6\"></div>\n	<li>\n		Si la cuenta del reloj llega a 0, no podrá continuar con la simulación y las preguntas sin responder contarán como incorrectas.\n	</li>\n	<div class=\"space-6\"></div>\n	<li>\n		La nota de esta simulación no tiene ninguna relación con la nota del examen real.\n	</li>\n</ol>";
    $btnsave = 1;
    $btnclose = route('exam.parameters.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div id="listaCampus" class="col-sm-10">
            <div class="clearfix">
                @include("shared.optionlists._campuslist", ['requerido' => '1'])
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div id="listaCarreras" class="col-sm-10">
            <div class="clearfix">
                @include("shared.optionlists._careerslist", ['requerido' => '1'])
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('duracion_examen', 'Duraci&oacute;n de examen:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-2">
            {!! Form::input('number','duracion_examen', 240, ['class' => 'form-control', 'placeholder' => 'Minutos']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_examen_test', 'C&oacute;digo de examen prueba:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-2">
            {!! Form::input('number','id_examen_test', null, ['class' => 'form-control', 'placeholder' => 'Ingrese c&oacute;digo de examen actual']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('editar_respuestas', '¿Editar respuestas?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('editar_respuestas', 'S', false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('instrucciones', 'Instrucciones:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::textarea('instrucciones', $defaultInst, ['id' => 'instrucciones', 'class' => 'form-control', 'size' => '100%x10', 'style' => 'resize: vertical;', 'required'])!!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
@include('shared.optionlists.functions')
<script type="text/javascript">
    $( window ).load(function() {
        getCareersByCampus();
    });
</script>
@endpush