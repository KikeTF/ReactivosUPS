@if(isset($mentionsList))
    {!! Form::select('id_mencion', $mentionsList, $mentionFilter,
        ['id' => 'id_mencion', 'class' => 'form-control'])
    !!}
@else
    {!! Form::select('id_mencion', ['-- No Aplica --'], 0, ['class' => 'form-control', 'readonly']) !!}
@endif