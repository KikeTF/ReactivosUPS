@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de formatos de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $newurl = route('reagent.formats.create');
    $columnas = array("nombre", "opciones_resp_min", "opciones_resp_max", "opciones_pregunta", "concepto_propiedad", "opciones_preg_min", "opciones_preg_max",  "imagenes", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>No. respuestas m&iacute;nimo</th>
                    <th>No. respuestas m&aacute;ximo</th>
                    <th>Opci&oacuten pregunta</th>
                    <th>Concepto propiedad</th>
                    <th>No. preguntas m&iacute;nimo</th>
                    <th>No. preguntas m&aacute;ximo</th>
                    <th>Im&aacute;genes</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($formats as $format)
                <tr>
                    <td>{{ $format->nombre }}</td>
                    <td>{{ $format->opciones_resp_min }}</td>
                    <td>{{ $format->opciones_resp_max }}</td>
                    <td>{{ $format->opciones_pregunta == 'S' ? 'Si' : 'No'  }}</td>
                    <td>{{ $format->concepto_propiedad == 'S' ? 'Si' : 'No'  }}</td>
                    <td>{{ $format->opciones_preg_min }}</td>
                    <td>{{ $format->opciones_preg_max }}</td>
                    <td>{{ $format->imagenes == 'S' ? 'Si' : 'No' }}</td>
                    <td>{{ $format->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="{{ route('reagent.formats.show', $format->id) }}">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="{{ route('reagent.formats.edit', $format->id) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="{{ route('reagent.formats.destroy', $format->id) }}">
                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                            </a>
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div class="inline pos-rel">
                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li>
                                        <a href="{{ route('reagent.formats.show', $format->id) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reagent.formats.edit', $format->id) }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reagent.formats.destroy', $format->id) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
                                            <span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection