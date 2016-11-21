

{!! Form::text('format_count', $formatList->count(), ['id' => 'format_count', 'hidden']) !!}
@foreach($formatList as $param)
    <div id="reagent_format_{{ $param->id }}" style="display: none;">
        {!! Form::text('f'.$param->id.'_format_resp_min', $param->opciones_resp_min, ['id' => 'f'.$param->id.'_format_resp_min', 'hidden']) !!}
        {!! Form::text('f'.$param->id.'_format_resp_max', $param->opciones_resp_max, ['id' => 'f'.$param->id.'_format_resp_max', 'hidden']) !!}
        {!! Form::text('f'.$param->id.'_format_preg_min', $param->opciones_preg_min, ['id' => 'f'.$param->id.'_format_preg_min', 'hidden']) !!}
        {!! Form::text('f'.$param->id.'_format_preg_max', $param->opciones_preg_max, ['id' => 'f'.$param->id.'_format_preg_max', 'hidden']) !!}

        @if($param->opciones_resp_min > 0)
            @if($param->imagenes == 'S')
                <div class="form-group">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-8">
                        {!! Form::label('f'.$param->id.'_imagen','Carga Imagen', ['class' => 'col-sm-3 btn btn-primary no-padding-right']) !!}
                        {!! Form::file('f'.$param->id.'_imagen', ['class' => 'form-control', 'style' => 'display:none;', 'onchange' => "$('#f".$param->id."_imagen_info').html($(this).val());"]) !!}
                        <span class='' id="f{{ $param->id }}_imagen_info"></span>
                    </div>
                </div>
            @endif

            @if($param->opciones_pregunta == 'S')
                <div class="form-group">
                    {!! Form::label('f'.$param->id.'_opcion_preg', 'Opciones de Pregunta:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                    <div class="col-sm-8">
                        <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                            <table id="f{{ $param->id }}_opcion_preg" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                                @for ($i = 1; $i <= $param->opciones_preg_max; $i++)
                                <tr>
                                    <td>
                                        {!! Form::text('f'.$param->id.'_conc_op_preg_'.$i, null, [
                                                    'id' => 'f'.$param->id.'_conc_op_preg_'.$i,
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Concepto de pregunta.',
                                                    'style' => 'height: 25px;',
                                                    ($i > $param->opciones_preg_min) ? 'disabled' : ''
                                            ]) !!}
                                    </td>
                                    @if($param->concepto_propiedad == 'S')
                                    <td>
                                        {!! Form::text('f'.$param->id.'_prop_op_preg_'.$i, null, [
                                                    'id' => 'f'.$param->id.'_prop_op_preg_'.$i,
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Propiedad de pregunta.',
                                                    'style' => 'height: 25px;',
                                                    ($i > $param->opciones_preg_min) ? 'disabled' : ''
                                            ]) !!}
                                    </td>
                                    @endif
                                    <td>
                                        @if($i > $param->opciones_preg_min)
                                        <div class="action-buttons">
                                            <div id="f{{ $param->id }}_activa_op_preg_{{ $i }}">
                                                <a class="green" onclick="activa_op_preg('{{ $i }}')" title="Activar">
                                                    <i class="ace-icon fa fa-check bigger-120"></i>
                                                </a>
                                            </div>
                                            <div id="f{{ $param->id }}_desactiva_op_preg_{{ $i }}" hidden>
                                                <a class="red" onclick="desactiva_op_preg('{{ $i }}')" title="Desactivar">
                                                    <i class="ace-icon fa fa-times bigger-120"></i>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                {!! Form::label('f'.$param->id.'_opcion_resp', 'Opciones de Respuesta:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                <div class="col-sm-8">
                    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                        <table id="f{{ $param->id }}_opcion_resp" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                            @for ($i = 1; $i <= $param->opciones_resp_max; $i++)
                                <tr>
                                    <td>
                                        {!! Form::radio('f'.$param->id.'_id_opcion_correcta', $i, false, ['id' => 'f'.$param->id.'_id_opcion_correcta_'.$i, ($i > $param->opciones_resp_min) ? 'disabled' : '']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('f'.$param->id.'_desc_op_resp_'.$i, null, [
                                                'id' => 'f'.$param->id.'_desc_op_resp_'.$i,
                                                'class' => 'form-control',
                                                'placeholder' => 'Descripción de respuesta.',
                                                'style' => 'height: 25px;',
                                                ($i > $param->opciones_resp_min) ? 'disabled' : ''
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('f'.$param->id.'_arg_op_resp_'.$i, null, [
                                                'id' => 'f'.$param->id.'_arg_op_resp_'.$i,
                                                'class' => 'form-control',
                                                'placeholder' => 'Argumento de respuesta.',
                                                'style' => 'height: 25px;',
                                                 ($i > $param->opciones_resp_min) ? 'disabled' : ''
                                        ]) !!}
                                    </td>
                                    <td>
                                        @if($i > $param->opciones_resp_min)
                                        <div class="action-buttons">
                                            <div id="f{{ $param->id }}_activa_op_resp_{{ $i }}">
                                                <a class="green" onclick="activa_op_resp('{{ $i }}')" title="Activar">
                                                    <i class="ace-icon fa fa-check bigger-120"></i>
                                                </a>
                                            </div>
                                            <div id="f{{ $param->id }}_desactiva_op_resp_{{ $i }}" hidden>
                                                <a class="red" onclick="desactiva_op_resp('{{ $i }}')" title="Desactivar">
                                                    <i class="ace-icon fa fa-times bigger-120"></i>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach