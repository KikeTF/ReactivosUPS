@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Listado de Perfiles')

@section('contenido')
    <?php
    $usetable = 1;
    $newurl = route('security.profiles.create');
    $columnas = array("nombre", "descripcion", "aprueba_reactivo", "aprueba_examen", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th style="text-align:center">Nombre</th>
                <th style="text-align:center">Descripci&oacute;n</th>
                <th style="text-align:center">¿Aprueba Reactivos?</th>
                <th style="text-align:center">¿Aprueba Examen?</th>
                <th style="text-align:center">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($profiles as $profile)
                <?php
                $urls = array(
                        'showurl' => route('security.profiles.show', $profile->id),
                        'editurl' => route('security.profiles.edit', $profile->id),
                        'destroyurl' => route('security.profiles.destroy', $profile->id)
                );
                ?>
                <tr>
                    <td>{{ $profile->nombre }}</td>
                    <td>{{ $profile->descripcion }}</td>
                    <td align="center">{{ $profile->aprueba_reactivo == 'S' ? 'Si' : 'No' }}</td>
                    <td align="center">{{ $profile->aprueba_examen == 'S' ? 'Si' : 'No' }}</td>
                    <td align="center">{{ $profile->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        @include('shared.templates._tablebuttons', $urls)
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection