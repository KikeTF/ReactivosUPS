<div class="form-group">
    <div class="col-sm-12" align="justify">{{ $reagent->planteamiento }}</div>
</div>

@if($reagent->format->opciones_pregunta == 'S')
    <div class="form-group">
        <div class="{{ ($reagent->format->concepto_propiedad == 'S') ? 'col-sm-6' : 'col-sm-12' }}">
            <table id="table-show" class="table">
                <thead>
                <tr>
                    <td></td>
                    <td>Concepto</td>
                </tr>
                </thead>
                <tbody>
                @foreach($reagent->questionsConcepts as $question)
                    <tr>
                        <td style="width: 40px;">{{ $question->numeral.'.' }}</td>
                        <td>{{ $question->concepto }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($reagent->format->concepto_propiedad == 'S')
            <div class="col-sm-6">
                <table id="table-show" class="table">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Propiedad</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reagent->questionsProperties as $question)
                        <tr>
                            <td style="width: 40px;">{{ $question->literal.'.' }}</td>
                            <td>{{ $question->propiedad }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endif

<h5 class="header smaller blue">Opciones de Respuesta</h5>

<div class="form-group">
    <div class="col-sm-12">
        <table id="table-show" class="table">
            <thead>
            <tr>
                <td colspan="2"></td>
                <td>Descripcion</td>
                <td>Argumento</td>
            </tr>
            </thead>
            <tbody>
            @foreach($reagent->answers as $answer)
                <tr style="{{ ($answer->opcion_correcta == 'S') ? 'background-color: #dff0d8;' : '' }}">
                    <td style="width: 35px;">
                        @if($answer->opcion_correcta == 'S')
                            <i class="fa fa-check green" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td style="width: 40px;">{{ $answer->numeral.'.' }}</td>
                    <td>{{ $answer->descripcion }}</td>
                    <td>{{ $answer->argumento }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="profile-user-info profile-user-info-striped">
    <div class="profile-info-row">
        <div class="profile-info-name">Campo de Conocimiento</div>
        <div class="profile-info-value"><span>{{ $reagent->field->nombre }}</span></div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name">Operaci&oacute;n Cognitiva</div>
        <div class="profile-info-value"><span>{{ $reagent->descripcion }}</span></div>
    </div>
</div>

