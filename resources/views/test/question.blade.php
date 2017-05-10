@extends('test.template')

@section('usuario', 'Usuario Test')

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => ['test.update', $question->id],
            'method' => 'PUT']) !!}

    <div class="page-header">
        <div class="btn-toolbar" style="margin: 0px">
            <div class="btn-group">
                <?php $indexNext = 0; ?>
                @foreach($test->answersDetails as $index => $det)
                    <?php if($question->id == $det->id) $indexNext = $index+1; ?>
                    <button class="{{ ($question->id == $det->id) ? 'btn btn-success' : (($det->id_opcion_resp > 0) ? 'btn btn-info' : 'btn btn-light') }}"
                            onclick="location.href='{{ route('test.question', ["id_test" => $det->id_resultado_cab, "id_question" => $det->id]) }}'; return false;"
                            {{ ($det->id_opcion_resp > 0) ? 'disabled' : '' }}>{{ $index+1 }}</button>
                @endforeach
            </div>
            <div class="btn-group pull-right">
                <?php
                $idNext = 0;
                if($indexNext < $test->answersDetails->count())
                    $idNext = $test->answersDetails[$indexNext]->id;
                ?>
                {!! Form::hidden('id_nextQuestion', $idNext) !!}
                <button type="submit" class="btn btn-success pull-right">
                    @if($idNext > 0)
                        Siguiente<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    @else
                        Finalizar
                    @endif
                </button>
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-12" align="justify">{{ $reagent->planteamiento }}</div>
    </div>

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
                    @foreach($reagent->questionsConcepts as $question)
                        <tr>
                            <td>{{ $question->numeral.'.'}}&nbsp;&nbsp;&nbsp;{{ $question->concepto }}</td>
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
                        @foreach($reagent->questionsProperties as $question)
                            <tr>
                                <td>{{ $question->literal.'.' }}&nbsp;&nbsp;&nbsp;{{ $question->propiedad }}</td>
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
                @foreach($reagent->answers as $answer)
                    <tr>
                        <td style="width: 50px">
                            <div class="radio" style="margin: 0;">
                                <label>
                                    {!! Form::radio('id_opcion_resp', $answer->id, (($answer->id == $question->id_opcion_resp) ? true : false), ['class' => 'ace', 'id' => 'id_opcion_resp' ]) !!}
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </td>
                        <td>{{ $answer->numeral.'.' }}&nbsp;&nbsp;&nbsp;{{ $answer->descripcion }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@push('specific-script')
<script type="text/javascript">

</script>
@endpush