@if(isset($mattersList))
    {!! Form::select('id_materia', $mattersList, $matterFilter,
        ['id' => 'id_materia', 'class' => 'form-control', 'placeholder' => '-- Seleccione Materia --', 'onchange' => 'getContentsByMatter()'])
    !!}
@else
    {!! Form::select('id_materia', ['-- Seleccione Materia --'], 0, ['class' => 'form-control']) !!}
@endif