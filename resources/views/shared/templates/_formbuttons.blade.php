<div class="form-group no-margin">
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
            <i class='ace-icon fa fa-repeat bigger-110 green' style="margin: 0"></i>
        </button>
    @endif

    @if(isset($btnclose))
        <button title="Cerrar" onclick="location.href='{{ $btnclose }}'; return false;" class="btn btn-white btn-danger btn-bold">
            <i class='ace-icon fa fa-close bigger-110 red' style="margin: 0"></i>
        </button>
    @endif
</div>

<br/>
