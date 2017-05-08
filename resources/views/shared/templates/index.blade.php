<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>Reactivos UPS</title>

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('ace/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ace/font-awesome/4.2.0/css/font-awesome.min.css') }}" />

    <!-- page specific plugin styles -->
    @stack('specific-styles')

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('ace/fonts/fonts.googleapis.com.css') }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('ace/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ace/css/chosen.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ace/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

    <!-- datatable styles -->
    {{--<link rel="stylesheet" href="{{ asset('ace/css/jquery.dataTables.min.css') }}" />--}}
    <link rel="stylesheet" href="{{ asset('ace/css/buttons.dataTables.min.css') }}" />

    <!-- common scripts -->
    <link rel="stylesheet" href="{{ asset('styles/shared/template.css') }}" />

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
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

</head>

<body class="no-skin">
    <div id="navbar" class="navbar navbar-default navbar-fixed-top">
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
                        <i class="fa fa-graduation-cap"></i>
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

                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <span class="user-info">
                                        <small>Bienvenido,</small>
                                        {{ Auth::user()->nombres }}
                                    </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="{{ route('auth.logout') }}">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Salir
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

        <div id="sidebar" class="sidebar responsive sidebar-fixed">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>

            @include('shared.templates._navoptions')

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
                            <small>
                                @yield('titulo', 'Reactivos UPS')
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                @yield('titulo2')
                            </small>
                            @yield('subtitulo', 'Reactivos UPS')
                        </h1>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="col-sm-12">

                                <section>
                                    @include('flash::message')
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
                        <span class="blue bolder">Universidad Polit&eacute;cnica Salesiana</span>
                        &copy; 2016
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
    <script src="{{ asset('ace/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery-ui.custom.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.flot.resize.min.js') }}"></script>
    <script src="{{ asset('ace/js/select2.min.js') }}"></script>
    <script src="{{ asset('ace/js/chosen.jquery.min.js') }}"></script>

    {{--@stack('datatable-script')--}}
    {{--<script src="{{ asset('ace/js/jquery-1.12.3.js') }}"></script>--}}
    <script src="{{ asset('ace/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('ace/js/dataTables.tableTools.min.js') }}"></script>
    <script src="{{ asset('ace/js/dataTables.colVis.min.js') }}"></script>
    <script src="{{ asset('ace/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('ace/js/spin.min.js') }}"></script>
    <script src="{{ asset('ace/js/jquery.validate.min.js') }}"></script>

    <!-- ace scripts -->
    <script src="{{ asset('ace/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('ace/js/ace.min.js') }}"></script>

    <!-- common scripts -->
    <script src="{{ asset('scripts/shared/index.js') }}"></script>
    <script src="{{ asset('scripts/shared/CapsLock.compressed.js') }}"></script>

    <!-- specific scripts -->
    @stack('specific-script')
    @stack('bar-chart-script')
    @stack('pie-chart-script')

    @if(isset($usetable))
        <script>
            $(function() {
                $('#_dataTable').DataTable({
                    processing: true,
                    responsive: true,
                    columns: [
                        @if(isset($isApproval))
                            { data: 'check', name: 'check', orderable: false, searchable: false },
                        @endif
                        @foreach ($columnas as $col)
                            { data: '{{ $col }}', name: '{{ $col }}' },
                        @endforeach
                            { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    @if(isset($isApproval))
                        sorting: [[1, 'asc']],
                    @elseif(isset($isReagent))
                        sorting: [[0, 'desc']],
                    @endif
                    @if( !isset($newurl) ) // Sin botones adicionales
                        dom: '<"clearfix"<"pull-right tableTools-container"<"btn-group btn-overlap"T>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
                    @else // Con boton de agregar nuevo
                        dom: '<"clearfix"<"dataTableButtons"<"pull-left tableTools-container"<"btn-group btn-overlap"B>>><"dataTableButtons"<"pull-right tableTools-container"<"btn-group btn-overlap"T>>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
                        buttons: {
                            dom: {
                                container: {
                                    tag: 'div'
                                },
                                buttonContainer: {
                                    tag: 'div',
                                    className: 'btn btn-white btn-primary btn-bold'
                                },
                                button: {
                                    tag: 'a',
                                    className: 'blue'
                                }
                            },
                            buttons: [{
                                text: "<i class='ace-icon fa fa-plus bigger-110 blue'></i>",
                                titleAttr: "Nuevo",
                                action: function ( e, dt, node, config ) {
                                    window.location.href = "{{ $newurl }}";
                                }
                            }]
                        },
                    @endif
                    tableTools: {
                        sSwfPath: "{{ asset('ace/swf/copy_csv_xls_pdf.swf') }}",
                        sSelectedClass: "success",
                        aButtons: [
                            {
                                sExtends: "copy",
                                sToolTip: "Copiar al Portapapeles",
                                sButtonClass: "btn btn-white btn-primary btn-bold",
                                sButtonText: "<i class='fa fa-copy bigger-110 pink'></i>"
                            },
                            {
                                sExtends: "xls",
                                sToolTip: "Exportar a Excel",
                                sButtonClass: "btn btn-white btn-primary  btn-bold",
                                sButtonText: "<i class='fa fa-file-excel-o bigger-110 green'></i>"
                            },

                            {
                                sExtends: "csv",
                                sToolTip: "Exportar a CSV",
                                sButtonClass: "btn btn-white btn-primary  btn-bold",
                                sButtonText: "<i class='fa fa-file-text-o bigger-110 gray'></i>"
                            },

                            {
                                sExtends: "pdf",
                                sToolTip: "Exportar a PDF",
                                sButtonClass: "btn btn-white btn-primary  btn-bold",
                                sButtonText: "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
                            },

                            {
                                sExtends: "print",
                                sToolTip: "Vista de Impresión",
                                sButtonClass: "btn btn-white btn-primary  btn-bold",
                                sButtonText: "<i class='fa fa-print bigger-110 grey'></i>",

                                sMessage: "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small></small></a></div></div>",

                                sInfo: "<h3 class='no-margin-top'>Vista de Impresión</h3>\
                                          <p>Por favor utilice la función de impresión de su navegador para imprimir esta tabla.\
                                          <br />Oprima <b>esc</b> cuando finalize.</p>",
                            }
                        ]
                    },
                    language: {
                        sProcessing:     "Procesando...",
                        sLengthMenu:     "Mostrar _MENU_ registros",
                        sZeroRecords:    "No se encontraron resultados",
                        sEmptyTable:     "Ningún dato disponible en esta tabla",
                        sInfo:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        sInfoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
                        sInfoPostFix:    "",
                        sSearch:         "Buscar:",
                        sUrl:            "",
                        sInfoThousands:  ",",
                        sLoadingRecords: "Cargando...",
                        oPaginate: {
                            sFirst:    "Primero",
                            sLast:     "Último",
                            sNext:     "Siguiente",
                            sPrevious: "Anterior"
                        },
                        oAria: {
                            sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
                            sSortDescending: ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
            });
        </script>
    @endif
</body>

</html>

