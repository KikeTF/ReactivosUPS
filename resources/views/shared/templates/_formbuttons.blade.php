<div class="form-group no-margin">
    <div class="pull-left">
        <button id="btn-aprobado" title="Aprobar" onclick="return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-thumbs-o-up bigger-110 blue' style="margin: 0"></i>
        </button>

        <button id="btn-rechazado" title="Rechazar" onclick="return false;" class="btn btn-white btn-grey btn-bold">
            <i class='ace-icon fa fa-thumbs-o-down bigger-110 grey' style="margin: 0"></i>
        </button>

        <div id="btn-rechazado" class="btn btn-white btn-grey btn-bold">
            <a class="grey" title="Rechazar" href="#">
                <i class='ace-icon fa fa-thumbs-o-down bigger-110 grey'></i>
            </a>
        </div>

        <div id="btn-comentario" class="btn btn-white btn-warning btn-bold">
            <a class="orange2" title="Comentarios" href="#">
                <i class='ace-icon fa fa-comment-o bigger-110 orange2'></i>
            </a>
        </div>

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
        <button title="Historial" onclick="location.href='{{ $btnprint }}'; return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-print bigger-110 blue' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnreply))
        <button id="btn-reenviar" title="Reenviar" onclick="return false;" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-reply bigger-110 blue' style="margin: 0"></i>
        </button>
        <div style="height: 35px; margin: 0 3px -14px 3px; display: inline-block; border: 1px solid #D9D9D9; border-width: 0 1px 0 0"></div>
    @endif

    @if(isset($btnsave))
        <button title="Guardar" type="submit" class="btn btn-white btn-primary btn-bold">
            <i class='ace-icon fa fa-save bigger-110 blue' style="margin: 0"></i>
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
