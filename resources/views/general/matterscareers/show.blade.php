@extends('shared.templates.index')

@section('titulo', 'General')
@section('subtitulo', 'Detalle de par&aacute;metros de materia')

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('general.matterscareers.edit', $mattercareer->id);
        $btnclose = route('general.matterscareers.index');
        ?>
        @include('shared.templates._formbuttons')

        <table class="table table-hover">
            <tr>
                <td><strong>C&oacute;digo:</strong></td>
                <td colspan="3">{{ $mattercareer->id }}</td>
            </tr>
            <tr>
                <td><strong>Campus:</strong></td>
                <td colspan="3">{{ $mattercareer->desc_campus }}</td>
            </tr>
            <tr>
                <td><strong>Carrera:</strong></td>
                <td colspan="3">{{ $mattercareer->desc_carrera }}</td>
            </tr>
            <tr>
                <td><strong>Menci&oacute;n:</strong></td>
                <td colspan="3">{{ $mattercareer->desc_mencion }}</td>
            </tr>
            <tr>
                <td><strong>&Aacute;rea:</strong></td>
                <td colspan="3">{{ $mattercareer->desc_area }}</td>
            </tr>
            <tr>
                <td><strong>Materia:</strong></td>
                <td colspan="3">{{ $mattercareer->desc_materia }}</td>
            </tr>
            <tr>
                <td><strong>Nivel:</strong></td>
                <td colspan="3">{{ $mattercareer->nivel }}</td>
            </tr>
            <tr>
                <td><strong>No. Reactivos Entregables:</strong></td>
                <td colspan="3">{{ $mattercareer->nro_reactivos_mat }}</td>
            </tr>
            <tr>
                <td><strong>¿Aplica Examen?:</strong></td>
                <td colspan="3">{{ $mattercareer->aplica_examen }}</td>
            </tr>
            <tr>
                <td><strong>No. Reactvos en Examen:</strong></td>
                <td colspan="3">{{ $mattercareer->nro_reactivos_exam }}</td>
            </tr>
            <tr>
                <td><strong>Responsable:</strong></td>
                <td colspan="3">{{ $mattercareer->usr_responsable }}</td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td colspan="3">{{ $mattercareer->estado }}</td>
            </tr>
            <tr>
                <td><strong>Creado por:</strong></td>
                <td>{{ $mattercareer->creado_por }}</td>
                <td><strong>Fecha de creación:</strong></td>
                <td>{{ $mattercareer->fecha_creacion }}</td>
            </tr>
            <tr>
                <td><strong>Modificado por:</strong></td>
                <td>{{ $mattercareer->modificado_por }}</td>
                <td><strong>Fecha de modificación:</strong></td>
                <td>{{ $mattercareer->fecha_modificacion }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
