@if(isset($careersList))
    {!! Form::select('id_carrera', $careersList, $careerFilter,
        ['id' => 'id_carrera', 'class' => 'form-control', 'placeholder' => '-- Seleccione Carrera --', 'onchange' => 'getMattersByCareer()'])
    !!}
@else
    {!! Form::select('id_carrera', ['-- Seleccione Carrera --'], 0, ['class' => 'form-control']) !!}
@endif
