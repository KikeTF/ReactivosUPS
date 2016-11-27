<div class="hidden-sm hidden-xs action-buttons">
    @if(isset($showurl))
        <a class="blue" href="{{ $showurl }}">
            <i class="ace-icon fa fa-search-plus bigger-130"></i>
        </a>
    @endif

    @if(isset($editurl))
        <a class="green" href="{{ $editurl }}">
            <i class="ace-icon fa fa-pencil bigger-130"></i>
        </a>
    @endif

    @if(isset($destroyurl))
        <a class="red" href="{{ $destroyurl }}">
            <i class="ace-icon fa fa-trash-o bigger-130"></i>
        </a>
    @endif
</div>
<div class="hidden-md hidden-lg">
    <div class="inline pos-rel">
        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
        </button>
        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
            @if(isset($showurl))
                <li>
                    <a href="{{ $showurl }}" class="tooltip-info" data-rel="tooltip" title="View">
                        <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                    </a>
                </li>
            @endif

            @if(isset($editurl))
                <li>
                    <a href="{{ $editurl }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                        <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                    </a>
                </li>
            @endif

            @if(isset($destroyurl))
                <li>
                    <a href="{{ $destroyurl }}" class="tooltip-error" data-rel="tooltip" title="Delete">
                        <span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>