@if( isset($notifications) )
<li class="light-blue">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon fa fa-bell icon-animated-bell"></i>
        <span class="badge badge-important">{{ $notifications['count'] }}</span>
    </a>

    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
        <li class="dropdown-header">
            <i class="ace-icon fa fa-exclamation-triangle"></i>
            {{ $notifications['count'].' Notificaciones' }}
        </li>

        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar">
                @foreach($notifications['detail'] as $detail)
                    <li>
                        <a href="{{ route($detail['route']) }}">
                            <div class="clearfix">
                            <span class="pull-left">
                                <i class="btn btn-xs no-hover btn-primary fa {{ $detail['icon'] }}"></i>
                                {{ $detail['name'] }}
                            </span>
                                <span class="pull-right badge badge-info">{{ $detail['count'] }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</li>
@endif