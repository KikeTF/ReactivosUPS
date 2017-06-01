<ul class="nav nav-list">
    <li class="{{ ((strcmp(\Request::route()->getName(), 'index') == 0) ? 'active' : '') }}">
        <a href="/">
            <i class="menu-icon fa fa-home home-icon"></i>
            <span class="menu-text"> Inicio </span>
        </a>
        <b class="arrow"></b>
    </li>

    @if( isset($navOptions) )
        <?php $currentRoute = substr(\Request::route()->getName(), 0, strripos(\Request::route()->getName(),'.')); ?>
        @foreach($navOptions as $option)
            <?php $isOpen = 0; ?>
            @foreach($navSuboptions->where('id_padre', $option->id) as $suboption)
                    <?php $route = substr($suboption->ruta, 0, strripos($suboption->ruta,'.')); ?>
                @if(strcmp($currentRoute, $route) == 0)
                    <?php $isOpen = 1 ?>
                @endif
            @endforeach
            <li class="{{ ($isOpen == 1) ? 'active open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon {{ $option->ruta }}"></i>
                    <span class="menu-text"> {{ $option->descripcion }} </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>

                <ul class="submenu">
                    @foreach($navSuboptions->where('id_padre', $option->id) as $suboption)
                        <?php $route = substr($suboption->ruta, 0, strripos($suboption->ruta,'.')); ?>
                        <li class="{{ ( (strcmp($currentRoute, $route) == 0) ? 'active' : '' ) }}">
                            <a href="{{ route($suboption->ruta) }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                {{ $suboption->descripcion }}
                            </a>
                            <b class="arrow"></b>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    @endif
</ul><!-- /.nav-list -->