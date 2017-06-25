<div class="form-group no-margin">

    <div class="pull-left">

    @if(isset($btnaprove))
        <button id="btn-aprobado" title="Aprobar" onclick="return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-thumbs-o-up bigger-110 blue' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btnreject))
        <button id="btn-rechazado" title="Rechazar" onclick="return false;" class="btn btn-white btn-grey btn-bold">
            <i class='ace-icon fa fa-thumbs-o-down bigger-110 grey' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btncomment))
        <button id="btn-comentario" title="Observacion" onclick="return false;" class="btn btn-white btn-warning btn-bold">
            <i class='ace-icon fa fa-comment-o bigger-110 orange2' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnreply))
        <button id="btn-reenviar" title="Enviar" onclick="return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-check-square-o bigger-110 blue' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnlist))
        <button title="Detalle" onclick="location.href='{{ $btnlist }}'; return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-list bigger-110 blue' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnhistory))
        <button title="Historial" onclick="location.href='{{ $btnhistory }}'; return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-history bigger-110 blue' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btnprint))
        <button title="Imprimir" onclick="window.open('{{ $btnprint }}','_blank'); return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-print bigger-110 blue' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnprint2))
        <button title="Imprimir" onclick="printReport(); return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-print bigger-110 blue' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnexamactivate))
        <button title="Activar para Simulador" onclick="location.href='{{ $btnexamactivate }}'; return false;" class="btn btn-white btn-success btn-bold">
            <i class="ace-icon fa fa-check bigger-120 green"></i>
            Activar para Simulador
        </button>
    @elseif(isset($btnexamactive))
        <span class="label label-xlg label-success"><i class="ace-icon fa fa-check bigger-120 white"></i> Activo en Simulador</span>
    @endif

    @if(isset($btnsave))
        <button title="Guardar" type="submit" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-save bigger-110 blue' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btnnew))
        <button title="Nuevo" onclick="location.href='{{ $btnnew }}'; return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-plus bigger-110 blue' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btnedit))
        <button title="Editar" onclick="location.href='{{ $btnedit }}'; return false;" class="btn btn-white btn-success btn-bold">
            <i class='ace-icon fa fa-pencil bigger-110 green' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btnrefresh))
        <button title="Refrescar" onclick="location.href='{{ $btnrefresh }}'; return false;" class="btn btn-white btn-success btn-bold">
            <i class='ace-icon fa fa-refresh bigger-110 green' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btndelete))
        <button title="Eliminar" onclick="location.href='{{ $btndelete }}'; return false;" class="btn btn-white btn-gray btn-bold">
            <i class='ace-icon fa fa-trash-o bigger-110 gray' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btndelete2))
        <button id="btn-eliminar" onclick="return false;" title="Eliminar" class="btn btn-white btn-gray btn-bold">
            <i class='ace-icon fa fa-trash-o bigger-110 gray' style="margin: 0"></i>
        </button>
    @endif
    </div>

    <div class="pull-right">
    @if(isset($btnclose))
        <button title="Cerrar" onclick="location.href='{{ $btnclose }}'; return false;" class="btn btn-white btn-danger btn-bold">
            <i class='ace-icon fa fa-close bigger-110 red' style="margin: 0"></i>
        </button>
    @endif
    </div>
</div>

<br/>
