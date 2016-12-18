@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Listado de usuarios')

@section('contenido')
    <?php
    $usetable = 1;
    $columnas = array("username", "nombres", "email", "tipo", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th style="text-align:center">Usuario</th>
                <th style="text-align:center">Nombres y Apellidos</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Tipo</th>
                <th style="text-align:center">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <?php
                $showurl = route('security.users.show', $user->id);
                $editurl = route('security.users.edit', $user->id);
                $destroyurl = route('security.users.destroy', $user->id);
                ?>
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->nombres.' '.$user->apellidos }}</td>
                    <td>{{ $user->email }}</td>
                    <td align="center">{{ $user->tipo == 'D' ? 'Docente' : 'Estudiante'  }}</td>
                    <td align="center">{{ $user->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        @include('shared.templates._tablebuttons')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection