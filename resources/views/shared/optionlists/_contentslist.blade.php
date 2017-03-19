@if(isset($contentsList))
    <select name="id_contenido_det" id="id_contenido_det" class="chosen-select form-control" data-placeholder="-- Seleccione Contenido --" required>
        <option value=""></option>
        @foreach($contentsList as $content)
            <option value="{{ $content->id }}">{{ $content->ContentDescription }}</option>
        @endforeach
    </select>
@else
    <select name="id_contenido_det" id="id_contenido_det" class="chosen-select form-control" data-placeholder="-- Seleccione Contenido --" required>
        <option value=""></option>
    </select>
@endif
