<ul class="nav nav-list">
    <li class="active">
        <a href="/">
            <i class="menu-icon fa fa-home home-icon"></i>
            <span class="menu-text"> Inicio </span>
        </a>
        <b class="arrow"></b>
    </li>

    @foreach($navOptions as $option)
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon {{ $option->ruta }}"></i>
                <span class="menu-text"> {{ $option->descripcion }} </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @foreach($navSuboptions->where('id_padre', $option->id) as $suboption)
                    <li class="">
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
</ul><!-- /.nav-list -->