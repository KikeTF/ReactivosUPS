@if($format->opciones_resp_min > 0)
    @if($format->imagenes == 'S')
        <div class="form-group">
            {!! Form::label('file','Cargar Imagen:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-9">
                {!! Form::file('file', ['id' => 'file', 'class' => 'input-file form-control']) !!}
            </div>
        </div>
    @endif

    @if($format->opciones_pregunta == 'S')
        <div class="form-group">
            {!! Form::label('opcion_preg', 'Opciones de Pregunta:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-9">
                <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
                    <table id="opcion_preg" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
                        <?php
                            $max_preg = (($format->opciones_preg_max >= $format->opciones_prop_max) ? $format->opciones_preg_max : $format->opciones_prop_max);
                            $max_conc = $format->opciones_preg_max;
                            $min_conc = $format->opciones_preg_min;
                            $max_prop = $format->opciones_prop_max;
                            $min_prop = $format->opciones_prop_min;

                            if(isset($questionsConc) && isset($questionsProp))
                                $preg = (($questionsConc->count() >= $questionsProp->count()) ? $questionsConc->count() : $questionsProp->count());

                            if(isset($questionsConc)){
                                $preg = isset($preg) ? $preg : (($max_preg >= $questionsConc->count()) ? $max_preg : $questionsConc->count());
                                $max_conc = (($max_conc >= $questionsConc->count()) ? $max_conc : $questionsConc->count());
                                $min_conc = (($min_conc >= $questionsConc->count()) ? $min_conc : $questionsConc->count());
                            }
                            if(isset($questionsProp)){
                                $preg = isset($preg) ? $preg : (($max_preg >= $questionsProp->count()) ? $max_preg : $questionsProp->count());
                                $max_prop = (($max_prop >= $questionsProp->count()) ? $max_prop : $questionsProp->count());
                                $min_prop = (($min_prop >= $questionsProp->count()) ? $min_prop : $questionsProp->count());
                            }

                            if(isset($questionsConc) && isset($questionsProp))
                                $max_preg = (($max_preg >= $preg) ? $max_preg : $preg);
                        ?>
                        @for ($i = 0; $i < $max_preg; $i++)
                        <tr>
                            @if($i < $max_conc)
                                <td style="text-align: right; width: 50px">
                                    {!! Form::label('', ($i+1).'. ',['class' => 'control-label']) !!}
                                    {!! Form::text('questionsConc['.$i.'][id]',
                                        ((isset($questionsConc) && $i < $questionsConc->count()) ? $questionsConc[$i]->id : null),
                                        [   'id' => 'conc_id_preg_'.$i, 'hidden', ($i >= $min_conc) ? 'disabled' : '' ])!!}
                                    {!! Form::text('questionsConc['.$i.'][numeral]',
                                        ((isset($questionsConc) && $i < $questionsConc->count()) ? $questionsConc[$i]->numeral : ($i+1)),
                                        [   'hidden', ($i >= $min_conc) ? 'disabled' : ''])!!}
                                </td>
                                <td>
                                    {!! Form::textarea('questionsConc['.$i.'][concepto]',
                                        ((isset($questionsConc) && $i < $questionsConc->count()) ? $questionsConc[$i]->concepto : null),
                                        [   'id' => 'conc_op_preg_'.$i, 'class' => 'form-control', 'placeholder' => 'Concepto de pregunta.',
                                            'size' => '100%x2', 'style' => 'resize: vertical;', ($i >= $min_conc) ? 'disabled' : '' ]) !!}
                                </td>
                                <td style="width: 50px">
                                    @if($i >= $format->opciones_preg_min)
                                        <div class="action-buttons">
                                            <div id="conc_activa_op_preg_{{ $i }}" {{($i < $min_conc) ? 'hidden' : ''}}>
                                                <label class="control-label green" onclick="formatOptionAction('{{ $i }}', 'C', 1)" title="Activar">
                                                    <i class="ace-icon fa fa-check bigger-120" style="cursor: pointer;"></i>
                                                </label>
                                            </div>
                                            <div id="conc_desactiva_op_preg_{{ $i }}" {{($i < $min_conc) ? '' : 'hidden'}}>
                                                <label class="control-label red" onclick="formatOptionAction('{{ $i }}', 'C', 0)" title="Desactivar">
                                                    <i class="ace-icon fa fa-times bigger-120" style="cursor: pointer;"></i>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @else
                                <td></td>
                                <td></td>
                                <td style="width: 50px"></td>
                            @endif
                            @if($format->concepto_propiedad == 'S')
                                @if($i < $max_prop)
                                    <td style="text-align: right; width: 50px">
                                        {!! Form::label('', strtolower($abc[$i]).') ',['class' => 'control-label']) !!}
                                        {!! Form::text('questionsProp['.$i.'][id]',
                                        ((isset($questionsProp) && $i < $questionsProp->count()) ? $questionsProp[$i]->id : null),
                                        [   'id' => 'prop_id_preg_'.$i, 'hidden', ($i >= $min_prop) ? 'disabled' : '' ])!!}
                                        {!! Form::text('questionsProp['.$i.'][literal]',
                                            ((isset($questionsProp) && $i < $questionsProp->count()) ? $questionsProp[$i]->literal : strtolower($abc[$i])),
                                            [   ($i >= $min_prop) ? 'disabled' : '', 'hidden' ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::textarea('questionsProp['.$i.'][propiedad]',
                                            ((isset($questionsProp) && $i < $questionsProp->count()) ? $questionsProp[$i]->propiedad : null),
                                            [   'id' => 'prop_op_preg_'.$i,
                                                'class' => 'form-control',
                                                'placeholder' => 'Propiedad de pregunta.',
                                                'size' => '100%x2',
                                                'style' => 'resize: vertical;',
                                                ($i >= $min_prop) ? 'disabled' : ''
                                            ]) !!}
                                    </td>
                                    <td style="width: 50px">
                                        @if($i >= $format->opciones_prop_min)
                                        <div class="action-buttons">
                                            <div id="prop_activa_op_preg_{{ $i }}" {{($i < $min_prop) ? 'hidden' : ''}}>
                                                <label class="control-label green" onclick="formatOptionAction('{{ $i }}', 'P', 1)" title="Activar">
                                                    <i class="ace-icon fa fa-check bigger-120" style="cursor: pointer;"></i>
                                                </label>
                                            </div>
                                            <div id="prop_desactiva_op_preg_{{ $i }}" {{($i < $min_prop) ? '' : 'hidden'}}>
                                                <label class="control-label red" onclick="formatOptionAction('{{ $i }}', 'P', 0)" title="Desactivar">
                                                    <i class="ace-icon fa fa-times bigger-120" style="cursor: pointer;"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td style="width: 50px"></td>
                                @endif
                            @endif
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
                    <?php
                    $max_resp = $format->opciones_resp_max;
                    $min_resp = $format->opciones_resp_min;
                    if(isset($answers)){
                        $max_resp = (($max_resp >= $answers->count()) ? $max_resp : $answers->count());
                        $min_resp = (($min_resp >= $answers->count()) ? $min_resp : $answers->count());
                    }
                    ?>
                    @for ($i = 0; $i < $max_resp; $i++)
                        <tr>
                            <td style="width: 70px">
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('opcion_correcta',
                                            ((isset($answers) && $i < $answers->count()) ? $answers[$i]->numeral : $abc[$i]),
                                            ((isset($answers) && $i < $answers->count()) ? (($answers[$i]->opcion_correcta == 'S') ? true : false) : false),
                                            ['class' => 'ace', 'id' => 'id_opcion_correcta_'.$i, ($i >= $min_resp) ? 'disabled' : '', 'required' ]) !!}
                                        <span class="lbl"> {{ $abc[$i].')' }}</span>
                                    </label>
                                </div>
                                {!! Form::text('answers['.$i.'][id]',
                                    ((isset($answers) && $i < $answers->count()) ? $answers[$i]->id : null),
                                    [   'id' => 'id_resp_'.$i, 'hidden', ($i >= $min_resp) ? 'disabled' : '' ]) !!}
                                {!! Form::text('answers['.$i.'][numeral]',
                                    ((isset($answers) && $i < $answers->count()) ? $answers[$i]->numeral : $abc[$i]),
                                    [   ($i >= $min_resp) ? 'disabled' : '', 'hidden' ]) !!}
                            </td>
                            <td>
                                <div class="clearfix">
                                {!! Form::textarea('answers['.$i.'][descripcion]',
                                    ((isset($answers) && $i < $answers->count()) ? $answers[$i]->descripcion : null),
                                    [   'id' => 'desc_op_resp_'.$i, 'class' => 'form-control', 'placeholder' => 'Descripción de respuesta.',
                                        'size' => '100%x2', 'style' => 'resize: vertical;', 'required', ($i >= $min_resp) ? 'disabled' : '' ]) !!}
                                </div>
                            </td>
                            <td>
                                <div class="clearfix">
                                {!! Form::textarea('answers['.$i.'][argumento]',
                                    ((isset($answers) && $i < $answers->count()) ? $answers[$i]->argumento : null),
                                    [   'id' => 'arg_op_resp_'.$i, 'class' => 'form-control', 'placeholder' => 'Argumento de respuesta.',
                                        'size' => '100%x2', 'style' => 'resize: vertical;', 'required', ($i >= $min_resp) ? 'disabled' : '' ]) !!}
                                </div>
                            </td>
                            <td style="width: 50px">
                                @if($i >= $format->opciones_resp_min)
                                <div class="action-buttons">
                                    <div id="activa_op_resp_{{ $i }}" {{($i < $min_resp) ? 'hidden' : ''}}>
                                        <label class="control-label green" onclick="formatOptionAction('{{ $i }}', 'A', 1)" title="Activar">
                                            <i class="ace-icon fa fa-check bigger-120" style="cursor: pointer;"></i>
                                        </label>
                                    </div>
                                    <div id="desactiva_op_resp_{{ $i }}" {{($i < $min_resp) ? '' : 'hidden'}}>
                                        <label class="control-label red" onclick="formatOptionAction('{{ $i }}', 'A', 0)" title="Desactivar">
                                            <i class="ace-icon fa fa-times bigger-120" style="cursor: pointer;"></i>
                                        </label>
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