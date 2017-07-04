@extends('test.template')

@section('usuario')
    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <span class="user-info">
                <small>Bienvenido,</small>
                {{ $question->answerHeader->nombres }}
            </span>

            <i class="ace-icon fa fa-caret-down"></i>
        </a>

        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
                <a href="{{ route('test.destroy', $test->id) }}">
                    <i class="ace-icon fa fa-power-off"></i>
                    Salir
                </a>
            </li>
        </ul>
    </li>
@endsection

@push('specific-styles')
    {!! HTML::style('ace/css/colorbox.min.css') !!}
@endpush

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => ['test.update', $question->id],
            'method' => 'PUT']) !!}

    {{--location.href='{{ route('test.question', ["id" => $det->id]) }}'; return false;--}}
    <div class="page-header">
        <div class="btn-toolbar" style="margin: 0px">
            <div class="btn-group">
                <?php $indexNext = 0; ?>
                @foreach($test->answersDetails->sortBy('id') as $index => $det)
                    <?php if($question->id == $det->id) $indexNext = $index+1; ?>
                    <button class="{{ ($question->id == $det->id) ? 'btn btn-success' : (($det->id_opcion_resp > 0) ? 'btn btn-info' : (($det->estado == 'P') ? 'btn btn-yellow' : 'btn btn-light')) }}"
                            onclick="processAnswer({{ $det->id }}); return false;"
                                {{ (($question->id != $det->id && $det->id_opcion_resp == 0 && $det->estado == 'A') || $test->parameter->editar_respuestas == 'N') ? 'disabled' : '' }}>{{ $index+1 }}</button>
                @endforeach
            </div>

            <div class="btn-group">
                <?php
                $idNext = 0;
                if($indexNext < $test->answersDetails->count())
                    $idNext = $test->answersDetails[$indexNext]->id;
                ?>
                <button class="btn btn-danger pull-right" onclick="processAnswer({{ $idNext }}); return false;">
                    @if($idNext > 0)
                        Siguiente<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    @else
                        Finalizar
                    @endif
                </button>
            </div>

            <div id="countdown" class="btn-group pull-right" style="padding: 6px 12px; font-size: 16px;"></div>
        </div>
    </div>

    {!! Form::hidden('id_nextQuestion', $idNext, ['id' => 'id_nextQuestion']) !!}
    {!! Form::hidden('duracion', $test->parameter->duracion_examen, ['id' => 'duracion']) !!}
    {!! Form::hidden('fecha_inicio', $test->fecha_inicio, ['id' => 'fecha_inicio']) !!}
    {!! Form::hidden('estado', "A", ['id' => 'estado']) !!}

    <small class="lighter">{{ $reagent->distributive->matterCareer->matter->descripcion }}</small>

    <div class="row form-group">
        <div class="col-sm-12" align="justify">{{ $reagent->planteamiento }}</div>
    </div>

    @if($reagent->imagen == 'S')
        <ul class="ace-thumbnails clearfix">
            <li>
                <a href="{{ route('reagent.reagents.image', $reagent->id) }}" data-rel="colorbox">
                    <img class="img-responsive" src="{{ route('reagent.reagents.image', $reagent->id) }}" style="max-width: 300px; width: 100%;" />
                </a>
            </li>
        </ul>
        <div class="space-6"></div>
    @endif

    @if($reagent->format->opciones_pregunta == 'S')
        <div class="row form-group">
            <div class="col-sm-6">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                    <tr>
                        <td><strong>Conceptos</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reagent->questionsConcepts as $conc)
                        <tr>
                            <td>{{ $conc->numeral.'.'}}&nbsp;&nbsp;&nbsp;{{ $conc->concepto }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($reagent->format->concepto_propiedad == 'S')
                <div class="col-sm-6">
                    <table class="table table-hover" style="margin-bottom: 0;">
                        <thead>
                        <tr>
                            <td><strong>Propiedades</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reagent->questionsProperties as $prop)
                            <tr>
                                <td>{{ $prop->literal.'.' }}&nbsp;&nbsp;&nbsp;{{ $prop->propiedad }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    <div class="row form-group">
        <div class="col-sm-12">
            <table class="table table-hover" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <td colspan="2"><strong>Seleccione su respuesta:</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($reagent->answers()->orderByRaw("RAND()")->get() as $answer)
                    <tr>
                        <td style="width: 50px">
                            <div class="radio" style="margin: 0; padding: 0; min-height: 0;">
                                <label>
                                    {!! Form::radio('id_opcion_resp', $answer->id, (($answer->id == $question->id_opcion_resp) ? true : false),
                                        ['class' => 'ace',
                                        'id' => 'id_opcion_resp_'.$answer->id,
                                         ($test->parameter->editar_respuestas == 'N' && $question->id_opcion_resp > 0) ? 'disabled' : '' ]) !!}
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </td>
                        <td>{{ $answer->descripcion }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@push('specific-styles')
    {!! HTML::style('countdown/css/jquery.countdown.css') !!}
@endpush

@push('specific-script')
    {!! HTML::script('ace/js/jquery.colorbox.min.js') !!}
    {!! HTML::script('ace/js/bootbox.min.js') !!}
    {!! HTML::script('countdown/js/jquery.plugin.min.js') !!}
    {!! HTML::script('countdown/js/jquery.countdown.min.js') !!}
    {!! HTML::script('countdown/js/jquery.countdown-es.js') !!}
    <script type="text/javascript">
        //$.countdown.setDefaults($.countdown.regionalOptions['']);
        $('#l10n').countdown($.countdown.regionalOptions['es']);
        $('#l10n').countdown($.extend({}, $.countdown.regionalOptions['es']));
        //$('#defaultCountdown').countdown({until: getLeftTime(), format: 'HMS'});

        var endTime;
        $('#countdown').countdown({
            until: getLeftTime(),
            format: 'HMS',
            //compact: true,
            layout: '<strong><span id="countdown-format">{hnn}{sep}{mnn}{sep}{snn}</span></strong>',
            description: 'red',
            onTick: finalCountDown,
            onExpiry: countDownExpiry
        });

        function getLeftTime() {
            var d = $('#fecha_inicio').val();
            var d1 = d.split(" ");
            var date = d1[0].split("-");
            var time = d1[1].split(":");
            var yyyy = date[0];
            var mm = date[1];
            var dd = date[2];
            var hh = time[0];
            var min = time[1];
            var ss = time[2];
            var startTime = new Date(yyyy, mm-1, dd, hh, min, ss);

            var limitTimeMS = $('#duracion').val()*60000;
            var currentTime = new Date();
            var elapsedTimeMS = (currentTime - startTime);
            var leftTimeMS = limitTimeMS - elapsedTimeMS;

            endTime = currentTime;
            endTime.setMilliseconds(endTime.getMilliseconds() + leftTimeMS);

            return endTime;
        }

        function finalCountDown(time){
            if (time[4] == 0 && time[5] < 5)
                $('#countdown-format').addClass('red');
        }

        function countDownExpiry(){
            $("#id_nextQuestion").val(0);
            $("#estado").val("E");
            $("#formulario").submit();
        }

        function processAnswer(idQuestion) {
            if (idQuestion > 0)
                $("#id_nextQuestion").val(idQuestion);

            var idResp = '0';
            var answerIsChecked = false;
            try {
                idResp = $("input[name=id_opcion_resp]:checked").val().toString();
                answerIsChecked = $(('#id_opcion_resp_'+idResp)).is(':checked');
            }
            catch(err) {
                answerIsChecked = false;
            }

            var message = "No ha seleccionado una respuesta. Desea continuar?";
            if( answerIsChecked ){
                if( $("#id_nextQuestion").val() > 0 )
                    $("#formulario").submit();
                else
                    confirmSubmit("Desea finalizar su examen?");
            }
            else if( $("#id_nextQuestion").val() > 0 )
                confirmSubmit("No ha seleccionado una respuesta. Desea continuar?");
            else
                confirmSubmit("No ha seleccionado una respuesta. Desea finalizar su examen?");
        }

        function confirmSubmit(message) {
            bootbox.confirm({
                message: message,
                buttons: {
                    confirm: {
                        label: 'Si',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result)
                        $("#formulario").submit();
                }
            });
        }

        $(window).load(function() {
            jQuery(function($) {
                var $overflow = '';
                var colorbox_params = {
                    rel: 'colorbox',
                    reposition:true,
                    scalePhotos:true,
                    scrolling:false,
                    previous:'<i class="ace-icon fa fa-arrow-left"></i>',
                    next:'<i class="ace-icon fa fa-arrow-right"></i>',
                    close:'&times;',
                    current:'{current} of {total}',
                    maxWidth:'100%',
                    maxHeight:'100%',
                    photo: true,
                    onOpen:function(){
                        $overflow = document.body.style.overflow;
                        document.body.style.overflow = 'hidden';
                    },
                    onClosed:function(){
                        document.body.style.overflow = $overflow;
                    },
                    onComplete:function(){
                        $.colorbox.resize();
                    }
                };

                $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
                $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


                $(document).one('ajaxloadstart.page', function(e) {
                    $('#colorbox, #cboxOverlay').remove();
                });
            })
        });
    </script>
@endpush