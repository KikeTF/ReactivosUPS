@if(isset($mattersList))
    {!! Form::select('id_materia', $mattersList, $matterFilter, [
            'id' => 'id_materia',
            'class' => 'form-control',
            'placeholder' => '-- Seleccione Materia --',
            'onchange' => 'getContentsByMatter()',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@else
    {!! Form::select('id_materia', [null => '-- Seleccione Materia --'], 0, [
            'id' => 'id_materia',
            'class' => 'form-control',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@endif