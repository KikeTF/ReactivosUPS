<div class="form-group">
    <div class="col-sm-4"><strong>Materia:</strong></div>
    <div class="col-sm-6">{{ $exam->matter }}</div>
</div>

<div class="form-group">
    <div class="col-sm-4"><strong>Contenido:</strong></div>
    <div class="col-sm-6">{{ $reagent->contentDetail->capitulo . " " . $reagent->contentDetail->tema }}</div>
</div>

<div class="form-group">
    <div class="col-sm-4"><strong>Planteamiento:</strong></div>
    <div class="col-sm-6">{{ $reagent->planteamiento }}</div>
</div>

<div class="form-group">
    <div class="col-sm-12"><strong>Opciones de Pregunta:</strong></div>
</div>
<div class="form-group">
    <table class="table table-hover">
        <thead>
        <tr>
            <td></td>
            <td><strong>Concepto</strong></td>
            <td></td>
            <td><strong>Propiedad</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($reagent->questionsConcepts as $question)
            <tr>
                <td>{{ $question->secuencia }}</td>
                <td>{{ $question->concepto }}</td>
                <td>{{ $question->secuencia_letra }}</td>
                <td>{{ $question->propiedad }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="form-group">
    <div class="col-sm-12"><strong>Opciones de Respuesta:</strong></div>
</div>
<div class="form-group">
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
                <td>{{ $answer->secuencia }}</td>
                <td>{{ $answer->descripcion }}</td>
                <td>{{ $answer->argumento }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="form-group">
    <div class="col-sm-4"><strong>Campo de Conocimiento:</strong></div>
    <div class="col-sm-8">{{ $reagent->field->nombre }}</div>
</div>
<div class="form-group">
    <div class="col-sm-4"><strong>Operacion Cognitiva:</strong></div>
    <div class="col-sm-8">{{ $reagent->descripcion }}</div>
</div>

