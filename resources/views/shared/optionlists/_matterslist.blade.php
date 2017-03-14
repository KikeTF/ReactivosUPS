{!! Form::label('id_materia', 'Seleccione Materia:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
{!! Form::select('id_materia', $matters, (isset($filters) ? $filters[2] : 0), ['class' => 'form-control', 'placeholder' => '-- Todas las Materias --']) !!}
