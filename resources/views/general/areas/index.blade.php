@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Listado de &Aacute;reas')

@section('contenido')
    <?php
    $usetable = 1;
    $columnas = array("cod_area", "descripcion", "id_usuario_resp", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center">C&oacute;digo</th>
                    <th style="text-align: center">Descripci&oacute;n</th>
                    <th style="text-align: center">Responsable</th>
                    <th style="text-align: center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if($areas->count() > 0)
                @foreach($areas as $area)
                    <?php
                    $urls = array(
                            'showurl' => route('general.areas.show', $area->id),
                            'editurl' => route('general.areas.edit', $area->id),
                            'destroyurl' => route('general.areas.destroy', $area->id)
                    );
                    ?>
                    <tr>
                        <td align="center">{{ $area->cod_area }}</td>
                        <td>{{ $area->descripcion }}</td>
                        <td>{{ ($area->id_usuario_resp > 0) ? $area->user->FullName : 'NO DEFINIDO' }}</td>
                        <td align="center">
                            <span class="{{ ($area->estado == 'A') ? 'label label-primary' : 'label' }}">
                                {{ ($area->estado == 'A') ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            @include('shared.templates._tablebuttons', $urls)
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
