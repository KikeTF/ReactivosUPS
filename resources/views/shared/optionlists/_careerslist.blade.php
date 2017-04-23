@if(isset($careersList))
    {!! Form::select('id_carrera', $careersList, $careerFilter, [
            'id' => 'id_carrera',
            'class' => 'form-control',
            'placeholder' => '-- Seleccione Carrera --',
            'onchange' => 'getMattersByCareer(); getMentionsByCareer();',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@else
    {!! Form::select('id_carrera', [null => '-- Seleccione Carrera --'], 0, [
            'id' => 'id_carrera',
            'class' => 'form-control',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@endif
