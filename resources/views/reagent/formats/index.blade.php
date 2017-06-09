@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
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
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">No. respuestas m&iacute;nimo</th>
                    <th style="text-align: center">No. respuestas m&aacute;ximo</th>
                    <th style="text-align: center">Opci&oacuten pregunta</th>
                    <th style="text-align: center">Concepto propiedad</th>
                    <th style="text-align: center">No. preguntas m&iacute;nimo</th>
                    <th style="text-align: center">No. preguntas m&aacute;ximo</th>
                    <th style="text-align: center">Im&aacute;genes</th>
                    <th style="text-align: center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($formats as $format)
                <?php
                $urls = array(
                        'showurl' => route('reagent.formats.show', $format->id),
                        'editurl' => route('reagent.formats.edit', $format->id),
                        'destroyurl' => route('reagent.formats.destroy', $format->id)
                );
                ?>
                <tr>
                    <td>{{ $format->nombre }}</td>
                    <td align="center">{{ $format->opciones_resp_min }}</td>
                    <td align="center">{{ $format->opciones_resp_max }}</td>
                    <td align="center">
                    @if($format->opciones_pregunta == 'S')
                        <a class="btn btn-xs btn-success" style="padding: 0px 3px 0px 3px">
                            <i class="ace-icon fa fa-check bigger-110" style="margin: 0"></i>
                        </a>
                    @else
                        <a class="btn btn-xs btn-danger"  style="padding: 0px 4px 0px 4px">
                            <i class="ace-icon fa fa-times  bigger-110" style="margin: 0"></i>
                        </a>
                        @endif
                        </td>
                    <td align="center">
                        @if($format->concepto_propiedad == 'S')
                            <a class="btn btn-xs btn-success" style="padding: 0px 3px 0px 3px">
                                <i class="ace-icon fa fa-check bigger-110" style="margin: 0"></i>
                            </a>
                        @else
                            <a class="btn btn-xs btn-danger"  style="padding: 0px 4px 0px 4px">
                                <i class="ace-icon fa fa-times  bigger-110" style="margin: 0"></i>
                            </a>
                        @endif
                    </td>
                    <td align="center">{{ $format->opciones_preg_min }}</td>
                    <td align="center">{{ $format->opciones_preg_max }}</td>
                    <td align="center">
                        @if($format->imagenes == 'S')
                            <a class="btn btn-xs btn-success" style="padding: 0px 3px 0px 3px">
                                <i class="ace-icon fa fa-check bigger-110" style="margin: 0"></i>
                            </a>
                        @else
                            <a class="btn btn-xs btn-danger"  style="padding: 0px 4px 0px 4px">
                                <i class="ace-icon fa fa-times  bigger-110" style="margin: 0"></i>
                            </a>
                        @endif
                    </td>
                    <td align="center">
                            <span class="{{ ($format->estado == 'A') ? 'label label-primary' : 'label' }}">
                                {{ ($format->estado == 'A') ? 'Activo' : 'Inactivo' }}
                            </span>
                    </td>
                    <td>
                        @include('shared.templates._tablebuttons', $urls)
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection