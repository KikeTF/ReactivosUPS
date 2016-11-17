@extends('shared.template.index')

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
                    <th>Nombre</th>
                    <th>Descripci&oacute;n</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($fields as $field)
                <tr>
                    <td>{{ $field->nombre }}</td>
                    <td>{{ $field->descripcion }}</td>
                    <td>{{ $field->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="{{ route('reagent.fields.show', $field->id) }}">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="{{ route('reagent.fields.edit', $field->id) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="{{ route('reagent.fields.destroy', $field->id) }}">
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
                                        <a href="{{ route('reagent.fields.show', $field->id) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reagent.fields.edit', $field->id) }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reagent.fields.destroy', $field->id) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
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
