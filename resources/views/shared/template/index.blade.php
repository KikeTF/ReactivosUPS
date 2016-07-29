<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>@yield('titulo', 'Inicio') - Reactivos UPS</title>

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('ace/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ace/font-awesome/4.2.0/css/font-awesome.min.css') }}" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('ace/fonts/fonts.googleapis.com.css') }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('ace/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <!--
    <link rel="stylesheet" href="ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
    -->
    <!--[endif]-->

    <!--[if lte IE 9]>
    <!--
    <link rel="stylesheet" href="ace/css/ace-ie.min.css" />
    -->
    <!--[endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="{{ asset('ace/js/ace-extra.min.js') }}"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <!--
    <script src="ace/js/html5shiv.min.js"></script>
    <script src="ace/js/respond.min.js"></script>
    -->
    <!--[endif]-->
</head>

<body class="no-skin">
    <div id="navbar" class="navbar navbar-default">
        <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
        </script>

        <div class="navbar-container" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>

            <div class="navbar-header pull-left">
                <a href="/" class="navbar-brand">
                    <small>
                        <i class="fa fa-book"></i>
                        Reactivos UPS
                    </small>
                </a>
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    <li class="light-blue">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                            <span class="badge badge-important">8</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-exclamation-triangle"></i>
                                8 Notifications
                            </li>

                            <li class="dropdown-content">
                                <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                        <span class="pull-left">
                                                            <i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
                                                            New Comments
                                                        </span>
                                                <span class="pull-right badge badge-info">+12</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="btn btn-xs btn-primary fa fa-user"></i>
                                            Bob just signed up as an editor ...
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

                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                        <span class="pull-left">
                                                            <i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
                                                            Followers
                                                        </span>
                                                <span class="pull-right badge badge-info">+11</span>
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

                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <span class="user-info">
                                        <small>Bienvenido,</small>
                                        Neptali Enrique
                                    </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="#">
                                    <i class="ace-icon fa fa-cog"></i>
                                    Settings
                                </a>
                            </li>

                            <li>
                                <a href="profile.html">
                                    <i class="ace-icon fa fa-user"></i>
                                    Profile
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a id="btnLogout" href="#">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>

        <div id="sidebar" class="sidebar                  responsive">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>

            <ul class="nav nav-list">
                <li class="active">
                    <a href="/">
                        <i class="menu-icon fa fa-home home-icon"></i>

                        <span class="menu-text"> Home </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-desktop"></i>
                        <span class="menu-text">
                                    UI &amp; Elements
                                </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i>

                                Layouts
                                <b class="arrow fa fa-angle-down"></b>
                            </a>

                            <b class="arrow"></b>

                            <ul class="submenu">
                                <li class="">
                                    <a href="top-menu.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Top Menu
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="two-menu-1.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Two Menus 1
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="two-menu-2.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Two Menus 2
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="mobile-menu-1.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Default Mobile Menu
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="mobile-menu-2.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Mobile Menu 2
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="mobile-menu-3.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Mobile Menu 3
                                    </a>

                                    <b class="arrow"></b>
                                </li>
                            </ul>
                        </li>

                        <li class="">
                            <a href="typography.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Typography
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="elements.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Elements
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="buttons.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Buttons &amp; Icons
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="content-slider.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Content Sliders
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="treeview.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Treeview
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="jquery-ui.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                jQuery UI
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="nestable-list.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Nestable Lists
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i>

                                Three Level Menu
                                <b class="arrow fa fa-angle-down"></b>
                            </a>

                            <b class="arrow"></b>

                            <ul class="submenu">
                                <li class="">
                                    <a href="#">
                                        <i class="menu-icon fa fa-leaf green"></i>
                                        Item #1
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="menu-icon fa fa-pencil orange"></i>

                                        4th level
                                        <b class="arrow fa fa-angle-down"></b>
                                    </a>

                                    <b class="arrow"></b>

                                    <ul class="submenu">
                                        <li class="">
                                            <a href="#">
                                                <i class="menu-icon fa fa-plus purple"></i>
                                                Add Product
                                            </a>

                                            <b class="arrow"></b>
                                        </li>

                                        <li class="">
                                            <a href="#">
                                                <i class="menu-icon fa fa-eye pink"></i>
                                                View Products
                                            </a>

                                            <b class="arrow"></b>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-list"></i>
                        <span class="menu-text"> Tables </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="tables.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Simple &amp; Dynamic
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="jqgrid.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                jqGrid plugin
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-pencil-square-o"></i>
                        <span class="menu-text"> Forms </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="form-elements.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Form Elements
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="form-elements-2.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Form Elements 2
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="form-wizard.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Wizard &amp; Validation
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="wysiwyg.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Wysiwyg &amp; Markdown
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="dropzone.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Dropzone File Upload
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="widgets.html">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text"> Widgets </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="calendar.html">
                        <i class="menu-icon fa fa-calendar"></i>

                        <span class="menu-text">
                                    Calendar

                                    <span class="badge badge-transparent tooltip-error" title="2 Important Events">
                                        <i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
                                    </span>
                                </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="gallery.html">
                        <i class="menu-icon fa fa-picture-o"></i>
                        <span class="menu-text"> Gallery </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-tag"></i>
                        <span class="menu-text"> More Pages </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="profile.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                User Profile
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="inbox.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Inbox
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="pricing.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Pricing Tables
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="invoice.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Invoice
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="timeline.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Timeline
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="email.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Email Templates
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="login.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Login &amp; Register
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-file-o"></i>

                        <span class="menu-text">
                                    Other Pages

                                    <span class="badge badge-primary">5</span>
                                </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="faq.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                FAQ
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="error-404.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Error 404
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="error-500.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Error 500
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="grid.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Grid
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="blank.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Blank Page
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.nav-list -->

            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>

            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>

        <div class="main-content">
            <div class="main-content-inner">

                <div class="page-content">
                    <div class="page-header">
                        <h1>
                            Reactivos UPS
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                Home
                            </small>
                        </h1>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="row">

                                <section>
                                    @yield('contenido')
                                </section>

                            </div><!-- /.row -->
                            <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->

        <div class="footer">
            <div class="footer-inner">
                <div class="footer-content">
                    <span class="bigger-120">
                        <span class="blue bolder">Ace</span>
                        Application &copy; 2016
                    </span>
                </div>
            </div>
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="{{ asset('ace/js/jquery.2.1.1.min.js') }}"></script>

    <!-- <![endif]-->

    <!--[if IE]>
    <!--
    <script src="ace/js/jquery.1.11.1.min.js"></script>
    -->
    <!--[endif]-->

    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='ace/js/jquery.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <!--
    <script type="text/javascript">
        window.jQuery || document.write("<script src='ace/js/jquery1x.min.js'>"+"<"+"/script>");
    </script>
    -->
    <!--[endif]-->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="{{ asset('ace/js/bootstrap.min.js') }}"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
    <!--
    <script src="ace/js/excanvas.min.js"></script>
    -->
    <!--[endif]-->
    <script src="{{ asset('ace/js/jquery-ui.custom.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.flot.resize.min.js') }}"></script>

    <!-- ace scripts -->
    <script src="{{ asset('ace/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('ace/js/ace.min.js') }}"></script>

    <script src="{{ asset('scripts/shared/template/index.js') }}"></script>

</body>

</html>

