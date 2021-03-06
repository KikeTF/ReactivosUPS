@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Listado de Perfiles')

@section('contenido')
    <?php
    $usetable = 1;
    $newurl = route('security.profiles.create');
    $columnas = array("nombre", "aprueba_reactivo", "aprueba_reactivos_masivo", "aprueba_examen", "restablece_password", "dashboard", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th style="text-align:center">Nombre</th>
                <th style="text-align:center">Aprueba Reactivos</th>
                <th style="text-align:center">Aprobaci&oacute;n Masiva de Reactivos</th>
                <th style="text-align:center">Desbloquea Reactivos Aprobados</th>
                <th style="text-align:center">Aprueba Examen</th>
                <th style="text-align:center">Restablece Contrase&ntilde;a</th>
                <th style="text-align:center">Dashboard</th>
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
                    <td align="center">
                        @if($profile->aprueba_reactivo == 'S')
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
                        @if($profile->aprueba_reactivos_masivo == 'S')
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
                        @if($profile->desbloquea_reactivos == 'S')
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
                        @if($profile->aprueba_examen == 'S')
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
                        @if($profile->restablece_password == 'S')
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
                        @if($profile->dashboard == 'S')
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
                            <span class="{{ ($profile->estado == 'A') ? 'label label-primary' : 'label' }}">
                                {{ ($profile->estado == 'A') ? 'Activo' : 'Inactivo' }}
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