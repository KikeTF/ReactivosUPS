@if(isset($mattersList))
    {!! Form::select('id_materia', $mattersList, (isset($filters) ? $filters[2] : 0),
        ['id' => 'id_materia', 'class' => 'form-control', 'placeholder' => '-- Seleccione Materia --'])
    !!}
@else
    {!! Form::select('id_materia', ['-- Seleccione Materia --'], 0, ['class' => 'form-control']) !!}
@endif