<div class="form-group">
    <div class="col-sm-12" align="justify">{{ $reagent->planteamiento }}</div>
</div>

@if($reagent->format->opciones_pregunta == 'S')
    <div class="form-group">
        <div class="col-sm-12"><strong>Opciones de Pregunta:</strong></div>
    </div>
    <div class="form-group">
        <div class="col-sm-6">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td></td>
                    <td><strong>Concepto</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($reagent->questionsConcepts as $question)
                    <tr>
                        <td>{{ $question->numeral }}</td>
                        <td>{{ $question->concepto }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($reagent->format->concepto_propiedad == 'S')
            <div class="col-sm-6">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td></td>
                        <td><strong>Propiedad</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reagent->questionsProperties as $question)
                        <tr>
                            <td>{{ $question->literal }}</td>
                            <td>{{ $question->propiedad }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endif

<div class="form-group">
    <div class="col-sm-12"><strong>Opciones de Respuesta:</strong></div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <td></td>
                <td><strong>Descripcion</strong></td>
                <td><strong>Argumento</strong></td>
            </tr>
            </thead>
            <tbody>
            @foreach($reagent->answers as $answer)
                <tr>
                    <td>{{ $answer->numeral }}</td>
                    <td>{{ $answer->descripcion }}</td>
                    <td>{{ $answer->argumento }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4"><strong>Campo de Conocimiento:</strong></div>
    <div class="col-sm-8">{{ $reagent->field->nombre }}</div>
</div>
<div class="form-group">
    <div class="col-sm-4"><strong>Operacion Cognitiva:</strong></div>
    <div class="col-sm-8">{{ $reagent->descripcion }}</div>
</div>

