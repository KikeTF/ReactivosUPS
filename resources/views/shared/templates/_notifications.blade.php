@if( isset($notifications) )
<li class="light-blue">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon fa fa-bell icon-animated-bell"></i>
        <span class="badge badge-important">{{ isset($notifications) ? '1' : '0' }}</span>
    </a>

    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
        <li class="dropdown-header">
            <i class="ace-icon fa fa-exclamation-triangle"></i>
            8 Notifications
        </li>

        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar">
                <li>
                    <a href="#">
                        <div class="clearfix">
                            <span class="pull-left">
                                <i class="btn btn-xs no-hover btn-primary fa fa-key"></i>
                                Cambio de Contrase&ntilde;a
                            </span>
                            <span class="pull-right badge badge-info">0</span>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <div class="clearfix">
                            <span class="pull-left">
                                <i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
                                New Orders
                            </span>
                            <span class="pull-right badge badge-success">+8</span>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="dropdown-footer">
            <a href="#">
                See all notifications
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </li>
    </ul>
</li>
@endif