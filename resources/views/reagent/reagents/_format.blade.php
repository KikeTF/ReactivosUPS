@if($format->opciones_resp_min > 0)
    @if($format->imagenes == 'S')
        <div class="form-group">
            {!! Form::label('imagen','Cargar Imagen:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-9">
                {!! Form::file('imagen', ['class' => 'input-file form-control']) !!}
            </div>
        </div>
    @endif

    @if($format->opciones_pregunta == 'S')
        <div class="form-group">
            {!! Form::label('opcion_preg', 'Opciones de Pregunta:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-9">
                <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                    <table id="opcion_preg" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                        @for ($i = 1; $i <= $format->opciones_preg_max; $i++)
                        <tr>
                            <td>
                                {{ $i }}
                            </td>
                            <td>
                                {!! Form::textarea('conc_op_preg[]'.$i, null, [
                                            'id' => 'conc_op_preg_'.$i,
                                            'class' => 'form-control',
                                            'placeholder' => 'Concepto de pregunta.',
                                            'size' => '100%x2',
                                            'style' => 'resize: vertical;',
                                            ($i > $format->opciones_preg_min) ? 'disabled' : ''
                                    ]) !!}
                            </td>
                            @if($format->concepto_propiedad == 'S')
                                <td>
                                    {{ $abc[$i-1] }}
                                </td>
                                <td>
                                    {!! Form::textarea('prop_op_preg[]', null, [
                                                'id' => 'prop_op_preg_'.$i,
                                                'class' => 'form-control',
                                                'placeholder' => 'Propiedad de pregunta.',
                                                'size' => '100%x2',
                                                'style' => 'resize: vertical;',
                                                ($i > $format->opciones_preg_min) ? 'disabled' : ''
                                        ]) !!}
                                </td>
                            @endif
                            <td>
                                @if($i > $format->opciones_preg_min)
                                <div class="action-buttons">
                                    <div id="activa_op_preg_{{ $i }}">
                                        <a class="green" onclick="activa_op_preg('{{ $i }}')" title="Activar">
                                            <i class="ace-icon fa fa-check bigger-120"></i>
                                        </a>
                                    </div>
                                    <div id="desactiva_op_preg_{{ $i }}" hidden>
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
        {!! Form::label('opcion_resp', 'Opciones de Respuesta:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-9">
            <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                <table id="opcion_resp" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                    @for ($i = 1; $i <= $format->opciones_resp_max; $i++)
                        <tr>
                            <td>
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('id_opcion_correcta', $i, false, ['class' => 'ace', 'id' => 'id_opcion_correcta_'.$i, ($i > $format->opciones_resp_min) ? 'disabled' : '', 'required']) !!}
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="clearfix">
                                {!! Form::textarea('desc_op_resp[]', null,
                                    [   'id' => 'desc_op_resp_'.$i,
                                        'class' => 'form-control',
                                        'placeholder' => 'Descripción de respuesta.',
                                        'size' => '100%x2',
                                        'style' => 'resize: vertical;',
                                        'required',
                                        ($i > $format->opciones_resp_min) ? 'disabled' : '' ]) !!}
                                </div>
                            </td>
                            <td>
                                <div class="clearfix">
                                {!! Form::textarea('arg_op_resp[]', null,
                                    [   'id' => 'arg_op_resp_'.$i,
                                        'class' => 'form-control',
                                        'placeholder' => 'Argumento de respuesta.',
                                        'size' => '100%x2',
                                        'style' => 'resize: vertical;',
                                        'required',
                                         ($i > $format->opciones_resp_min) ? 'disabled' : '' ]) !!}
                                </div>
                            </td>
                            <td>
                                @if($i > $format->opciones_resp_min)
                                <div class="action-buttons">
                                    <div id="activa_op_resp_{{ $i }}">
                                        <a class="green" onclick="activa_op_resp('{{ $i }}')" title="Activar">
                                            <i class="ace-icon fa fa-check bigger-120"></i>
                                        </a>
                                    </div>
                                    <div id="desactiva_op_resp_{{ $i }}" hidden>
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