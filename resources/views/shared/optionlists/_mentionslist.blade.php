@if(isset($mentionsList))
    {!! Form::select('id_mencion', $mentionsList, $mentionFilter, [
            'id' => 'id_mencion',
            'class' => 'form-control',
            'placeholder' => '-- Seleccione Menci&oacute;n --',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@else
    {!! Form::select('id_mencion', [null => '-- No Aplica --'], 0, [
            'id' => 'id_mencion',
            'class' => 'form-control',
            'readonly'
        ])
    !!}
@endif