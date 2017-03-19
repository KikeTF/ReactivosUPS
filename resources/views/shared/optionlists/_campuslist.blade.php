@if(isset($campusList))
    {!! Form::select('id_campus', $campusList, (isset($filters) ? $filters[0] : 0),
        ['id' => 'id_campus', 'class' => 'form-control', 'placeholder' => '--Seleccione Campus--', 'onchange' => 'getCareersByCampus()'])
    !!}
@else
    {!! Form::select('id_campus', ['-- Seleccione Campus --'], 0, ['class' => 'form-control']) !!}
@endif