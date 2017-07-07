@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Notificaciones')

@section('contenido')
    <?php
    $usetable = 1;
    $columnas = array("fecha", "tipo", "id_usuario");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th style="text-align:center">Fecha</th>
                <th style="text-align:center">Tipo</th>
                <th style="text-align:center">Usuario</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($notificationsList as $notif)
                <tr>
                    <td>{{ $notif->fecha }}</td>
                    <td>{{ $typeList[$notif->tipo].' ('.$notif->veces.')' }}</td>
                    <td>{{ $notif->user->FullName }}</td>
                    <td>
                        <a class="blue" href="{{ route('general.notifications.update', $notif->id) }}">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection