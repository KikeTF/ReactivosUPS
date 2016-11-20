<?php
$formatParam = $formatList;
$id_formato = 0;
?>

<div class="form-group">
    {!! Form::label('planteamiento', 'Planteamiento:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
    <div class="col-sm-8">
        {!! Form::textarea('planteamiento', null, ['class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;'])!!}
    </div>
</div>

<div id="reagent_format_{{ $id_formato+1 }}" style="display: none;">

@if($formatParam[$id_formato]->opciones_resp_min > 0)

    @if($formatParam[$id_formato]->imagenes == 'S')
        <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-8">
                {!! Form::label('imagen','Carga Imagen', ['class' => 'col-sm-3 btn btn-primary no-padding-right']) !!}
                {!! Form::file('imagen', ['class' => 'form-control', 'style' => 'display:none;', 'onchange' => "$('#imagen-info').html($(this).val());"]) !!}
                <span class='' id="imagen-info"></span>
            </div>
        </div>
    @endif

    @if($formatParam[$id_formato]->opciones_pregunta == 'S')
        <div class="form-group">
            {!! Form::label('opcion_preg', 'Opciones de Pregunta:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
            <div class="col-sm-8">
                <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                    <table id="opcion_preg" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                        @for ($i = 1; $i <= $formatParam[$id_formato]->opciones_preg_max; $i++)
                        <tr>
                            <td>
                                {!! Form::text('conc_op_preg_'.$i, null, [
                                            'id' => 'conc_op_preg_'.$i,
                                            'class' => 'form-control',
                                            'placeholder' => 'Concepto de pregunta.',
                                            'style' => 'height: 25px;',
                                            ($i > $formatParam[$id_formato]->opciones_preg_min) ? 'disabled' : ''
                                    ]) !!}
                            </td>
                            @if($formatParam[$id_formato]->concepto_propiedad == 'S')
                            <td>
                                {!! Form::text('prop_op_preg_'.$i, null, [
                                            'id' => 'prop_op_preg_'.$i,
                                            'class' => 'form-control',
                                            'placeholder' => 'Propiedad de pregunta.',
                                            'style' => 'height: 25px;',
                                            ($i > $formatParam[$id_formato]->opciones_preg_min) ? 'disabled' : ''
                                    ]) !!}
                            </td>
                            @endif
                            <td>
                                @if($i > $formatParam[$id_formato]->opciones_preg_min)
                                <div class="action-buttons">
                                    <div id="activa_op_preg_{{ $i }}">
                                        <a class="green" onclick="activa_op_preg({{ $i }})" title="Activar">
                                            <i class="ace-icon fa fa-check bigger-120"></i>
                                        </a>
                                    </div>
                                    <div id="desactiva_op_preg_{{ $i }}" hidden>
                                        <a class="red" onclick="desactiva_op_preg({{ $i }})" title="Desactivar">
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
        {!! Form::label('opcion_resp', 'Opciones de Respuesta:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                <table id="opcion_resp" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                    @for ($i = 1; $i <= $formatParam[$id_formato]->opciones_resp_max; $i++)
                        <tr>
                            <td>
                                <input type="radio" name="id_opcion_correcta" id="id_opcion_correcta_{{ $i }}" value="{{ $i }}" {{($i == 1) ? 'checked' : ''}} {{($i > $formatParam[$id_formato]->opciones_resp_min) ? 'disabled' : ''}}>
                            </td>
                            <td>
                                {!! Form::text('desc_op_resp_'.$i, null, [
                                        'id' => 'desc_op_resp_'.$i,
                                        'class' => 'form-control',
                                        'placeholder' => 'Descripción de respuesta.',
                                        'style' => 'height: 25px;',
                                        ($i > $formatParam[$id_formato]->opciones_resp_min) ? 'disabled' : ''
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::text('arg_op_resp_'.$i, null, [
                                        'id' => 'arg_op_resp_'.$i,
                                        'class' => 'form-control',
                                        'placeholder' => 'Argumento de respuesta.',
                                        'style' => 'height: 25px;',
                                         ($i > $formatParam[$id_formato]->opciones_resp_min) ? 'disabled' : ''
                                ]) !!}
                            </td>
                            <td>
                                @if($i > $formatParam[$id_formato]->opciones_resp_min)
                                <div class="action-buttons">
                                    <div id="activa_op_resp_{{ $i }}">
                                        <a class="green" onclick="activa_op_resp({{ $i }})" title="Activar">
                                            <i class="ace-icon fa fa-check bigger-120"></i>
                                        </a>
                                    </div>
                                    <div id="desactiva_op_resp_{{ $i }}" hidden>
                                        <a class="red" onclick="desactiva_op_resp({{ $i }})" title="Desactivar">
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