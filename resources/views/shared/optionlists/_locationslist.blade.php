@if(isset($locationsList))
    {!! Form::select('id_sede', $locationsList, (isset($filters['id_sede']) ? (int)$filters['id_sede'] : 0), [
            'id' => 'id_sede',
            'class' => 'form-control',
            'placeholder' => '--Seleccione Sede--',
            'onchange' => 'getCampusByLocation()',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@else
    {!! Form::select('id_sede', [null => '-- Seleccione Sede --'], 0, [
            'id' => 'id_sede',
            'class' => 'form-control',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@endif