@if(isset($campusList))
    {!! Form::select('id_campus', $campusList, (isset($id_campus_test) ? $id_campus_test : (isset($filters) ? $filters[0] : 0)), [
            'id' => 'id_campus',
            'class' => 'form-control',
            'placeholder' => '--Seleccione Campus--',
            'onchange' => 'getCareersByCampus(this.form.id)',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@else
    {!! Form::select('id_campus', [null => '-- Seleccione Campus --'], 0, [
            'id' => 'id_campus',
            'class' => 'form-control',
            ((isset($requerido) && $requerido == 1) ? 'required' : '')
        ])
    !!}
@endif