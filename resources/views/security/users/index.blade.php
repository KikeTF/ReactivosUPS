@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Listado de usuarios')

@section('contenido')
    <?php
    $usetable = 1;
    $columnas = array("nombres", "username", "email", "tipo", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th style="text-align:center">Nombre Completo</th>
                <th style="text-align:center">Usuario</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Tipo</th>
                <th style="text-align:center">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <?php
                $urls = array(
                    'showurl' => route('security.users.show', $user->id),
                    'editurl' => route('security.users.edit', $user->id),
                    'destroyurl' => route('security.users.destroy', $user->id)
                );
                ?>
                <tr>
                    <td>{{ $user->FullName }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td align="center">{{ $user->tipo == 'D' ? 'Docente' : 'Estudiante'  }}</td>
                    <td align="center">
                            <span class="{{ ($user->estado == 'A') ? 'label label-primary' : 'label' }}">
                                {{ ($user->estado == 'A') ? 'Activo' : 'Inactivo' }}
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