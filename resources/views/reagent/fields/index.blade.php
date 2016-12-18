@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de campos de conocimiento')

@section('contenido')
    <?php
        $usetable = 1;
        $newurl = route('reagent.fields.create');
        $columnas = array("nombre", "descripcion", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Descripci&oacute;n</th>
                    <th style="text-align: center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($fields as $field)
                <?php
                $showurl = route('reagent.fields.show', $field->id);
                $editurl = route('reagent.fields.edit', $field->id);
                $destroyurl = route('reagent.fields.destroy', $field->id);
                ?>
                <tr>
                    <td>{{ $field->nombre }}</td>
                    <td>{{ $field->descripcion }}</td>
                    <td align="center">{{ $field->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        @include('shared.templates._tablebuttons')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
