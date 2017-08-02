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
    {!! HTML::style('ace/css/bootstrap.min.css') !!}
    {!! HTML::style('ace/font-awesome/4.2.0/css/font-awesome.min.css') !!}

    <!-- page specific plugin styles -->
    @stack('specific-styles')

    <!-- text fonts -->
    {!! HTML::style('ace/fonts/fonts.googleapis.com.css') !!}

    <!-- ace styles -->
    {!! HTML::style('ace/css/select2.min.css') !!}
    {!! HTML::style('ace/css/chosen.min.css') !!}
    {!! HTML::style('ace/css/ace.min.css', ['class' => 'ace-main-stylesheet', 'id' => 'main-ace-style']) !!}

    <!-- datatable styles -->
    {!! HTML::style('ace/css/buttons.dataTables.min.css') !!}

    <!-- common scripts -->
    {!! HTML::style('styles/shared/template.css') !!}

    <!-- jquery -->
    {!! HTML::script('ace/js/jquery.2.1.1.min.js') !!}

    <!-- ace settings handler -->
    {!! HTML::script('ace/js/ace-extra.min.js') !!}

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

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
                <a href="{{ route('index') }}" class="navbar-brand">
                    <small>
                        <i class="fa fa-graduation-cap"></i>
                        Reactivos UPS
                    </small>
                </a>
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    @include('shared.templates._notifications')

                    <li class="transparent">
                        <a>
                            <span class="user-info-no-collapse">
                                Periodo {{ \Session::get('codPeriodo') }}
                                <small>{{ \Session::get('descPeriodo') }}</small>
                            </span>
                        </a>
                    </li>

                    <li class="transparent">
                        <a>
                            <span class="user-info-no-collapse">
                                <small>Perfil</small>
                                {{ \Session::get('descPerfil') }}
                            </span>
                        </a>
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
                                <a href="{{ route('account.userProfile') }}">
                                    <i class="ace-icon fa fa-user"></i>
                                    Perfil de Usuario
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('account.changePassword') }}">
                                    <i class="ace-icon fa fa-key"></i>
                                    Cambio de Contrase&ntilde;a
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('auth.logout') }}">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Cerrar Sesi&oacute;n
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

        @include('shared.templates._navoptions')

        <div class="main-content">
            <div class="main-content-inner">

                <div class="page-content">
                    <div class="page-header">
                        <h1>
                            <small id="small-title">
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
                            <section>
                                @include('flash::message')
                                @yield('contenido')
                            </section>
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
                        &copy; 2017
                    </span>
                </div>
            </div>
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container -->

    <!-- basic scripts -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='ace/js/jquery.min.js'>"+"<"+"/script>");
    </script>
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    {!! HTML::script('ace/js/bootstrap.min.js') !!}
    {!! HTML::script('ace/js/jquery-ui.min.js') !!}
    {!! HTML::script('ace/js/jquery-ui.custom.min.js') !!}
    {!! HTML::script('ace/js/jquery.ui.touch-punch.min.js') !!}
    {!! HTML::script('ace/js/jquery.easypiechart.min.js') !!}
    {!! HTML::script('ace/js/jquery.sparkline.min.js') !!}
    {!! HTML::script('ace/js/jquery.flot.min.js') !!}
    {!! HTML::script('ace/js/jquery.flot.pie.min.js') !!}
    {!! HTML::script('ace/js/jquery.flot.resize.min.js') !!}
    {!! HTML::script('ace/js/select2.min.js') !!}
    {!! HTML::script('ace/js/chosen.jquery.min.js') !!}

    {{--@stack('datatable-script')--}}
    {{--<script src="{{ asset('ace/js/jquery-1.12.3.js') }}"></script>--}}
    {!! HTML::script('ace/js/jquery.dataTables.min.js') !!}
    {!! HTML::script('ace/js/jquery.dataTables.bootstrap.min.js') !!}
    {!! HTML::script('ace/js/dataTables.tableTools.min.js') !!}
    {!! HTML::script('ace/js/dataTables.colVis.min.js') !!}
    {!! HTML::script('ace/js/dataTables.buttons.min.js') !!}
    {!! HTML::script('ace/js/spin.min.js') !!}
    {!! HTML::script('ace/js/jquery.validate.min.js') !!}
    {!! HTML::script('ace/js/bootbox.min.js') !!}
    {{--<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>--}}

    <!-- ace scripts -->
    {!! HTML::script('ace/js/ace-elements.min.js') !!}
    {!! HTML::script('ace/js/ace.min.js') !!}

    <!-- common scripts -->
    {!! HTML::script('scripts/shared/index.js') !!}
    {!! HTML::script('scripts/shared/CapsLock.compressed.js') !!}

    <!-- specific scripts -->
    @stack('specific-script')

    @if(isset($usetable))
        <script>
            $(function() {
                $('#_dataTable').DataTable({
                    processing: true,
                    responsive: true,
                    columns: [
                        @if( isset($isReagent) )
                            { data: 'check', name: 'check', orderable: false, searchable: false },
                        @endif
                        @foreach ($columnas as $col)
                            { data: '{{ $col }}', name: '{{ $col }}' },
                        @endforeach
                            { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    @if( isset($isReagent) )
                        sorting: [[1, 'desc']],
                    @elseif( isset($isExam) )
                        sorting: [[0, 'desc']],
                    @endif
                    @if( isset($newurl) ) // Sin botones adicionales
                        dom: '<"clearfix"<"pull-left tableTools-container"<"btn-group btn-overlap"B>><"pull-right tableTools-container"<"btn-group btn-overlap"T>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
                        buttons: {
                            dom: {
                                container: {
                                    tag: 'div',
                                    className: 'DTTT_container'
                                },
                                //buttonContainer: {
                                //    tag: 'div',
                                //    className: 'DTTT_container'
                                //},
                                button: {
                                    tag: 'a',
                                    className: 'DTTT_button btn btn-white btn-primary btn-bold'
                                }
                            },
                            buttons: [
                                {
                                    name: 'ToolTables__dataTable_5',
                                    text: "<i class='ace-icon fa fa-plus bigger-110 blue'></i>",
                                    titleAttr: "Nuevo",
                                    action: function ( e, dt, node, config ) {
                                        window.location.href = "{{ $newurl }}";
                                    }
                                },
                                @if( isset($indexPrint) )
                                {
                                    name: 'ToolTables__dataTable_6',
                                    text: "<i class='ace-icon fa fa-print bigger-110 blue'></i>",
                                    titleAttr: "Imprimir",
                                    action: function ( e, dt, node, config ) {
                                        var ids = new Array();
                                        $("input:checkbox[name=id]:checked").each(function(){
                                            ids.push($(this).val());
                                        });

                                        if(ids.length > 0)
                                        {
                                            window.open("{{ Route("reagent.reagents.report", 0) }}?ids=["+ids+"]",'_blank');
                                            //window.location.replace("{{ Route("reagent.reagents.report", 0) }}");
                                        }
                                        else
                                        {
                                            bootbox.alert({
                                                message: "Seleccione al menos un reactivo para continuar!",
                                                buttons: {
                                                    'ok': {
                                                        label: 'Cerrar',
                                                        className: 'btn-danger'
                                                    }
                                                }
                                            });
                                        }
                                    }
                                }
                                @endif
                            ]
                        },
                    @elseif( isset($isReagent) ) // Sin botones adicionales
                        dom: '<"clearfix"<"pull-left tableTools-container"<"btn-group btn-overlap"B>><"pull-right tableTools-container"<"btn-group btn-overlap"T>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
                        buttons: {
                            dom: {
                                container: {
                                    tag: 'div',
                                    className: 'DTTT_container'
                                },
                                //buttonContainer: {
                                //    tag: 'div',
                                //    className: 'DTTT_container'
                                //},
                                button: {
                                    tag: 'a',
                                    className: 'DTTT_button btn btn-white btn-primary btn-bold'
                                }
                            },
                            buttons: [
                                @if( isset($isApproval) )
                                {
                                    name: 'ToolTables__dataTable_5',
                                    text: "<i class='ace-icon fa fa-thumbs-o-up bigger-110 blue'></i>",
                                    titleAttr: "Aprobar",
                                    action: function ( e, dt, node, config ) {
                                        var ids = new Array();
                                        var noApproveReaCount = 0;
                                        $("input:checkbox[name=id]:checked").each(function(){
                                            if($(this).data("approve") === 'S')
                                                ids.push($(this).val());
                                            else
                                                noApproveReaCount++;
                                        });

                                        if(noApproveReaCount > 0)
                                        {
                                            bootbox.alert({
                                                message: "Seleccione unicamente reactivos en estado \"Enviado\" para continuar!",
                                                buttons: {
                                                    'ok': {
                                                        label: 'Cerrar',
                                                        className: 'btn-danger'
                                                    }
                                                }
                                            });
                                        }
                                        else if(ids.length > 0)
                                        {
                                            bootbox.prompt({
                                                title: "Ingrese sus comentarios...",
                                                inputType: 'textarea',
                                                buttons: {
                                                    'confirm': {
                                                        label: 'Aprobar',
                                                        className: 'btn-info'
                                                    },
                                                    'cancel': {
                                                        label: 'Cancelar',
                                                        className: 'btn-default'
                                                    }
                                                },
                                                callback: function (result) {
                                                    if (result === null) {
                                                        console.log("Ok");
                                                    } else {
                                                        $.ajax({
                                                            type: 'GET',
                                                            url: "{{ Route("reagent.approvals.comment", 0) }}",
                                                            data: {'comentario':result, 'id_estado':5, 'ids':ids},
                                                            dataType: "json",
                                                            async: true,
                                                            cache: false,
                                                            error: function (e) {
                                                                console.log(e);
                                                            },
                                                            success: function (result) {
                                                                if (result.valid) {
                                                                    window.location.replace("{{ Route("reagent.approvals.index") }}");
                                                                }
                                                                else {
                                                                    alert('Error');
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            });
                                        }
                                        else
                                        {
                                            bootbox.alert({
                                                message: "Seleccione al menos un reactivo para continuar!",
                                                buttons: {
                                                    'ok': {
                                                        label: 'Cerrar',
                                                        className: 'btn-danger'
                                                    }
                                                }
                                            });
                                        }
                                    }
                                },
                                @endif
                                @if( isset($indexPrint) )
                                {
                                    name: 'ToolTables__dataTable_6',
                                    text: "<i class='ace-icon fa fa-print bigger-110 blue'></i>",
                                    titleAttr: "Imprimir",
                                    action: function ( e, dt, node, config ) {
                                        var ids = new Array();
                                        $("input:checkbox[name=id]:checked").each(function(){
                                            ids.push($(this).val());
                                        });

                                        if(ids.length > 0)
                                        {
                                            window.open("{{ Route("reagent.reagents.report", 0) }}?ids=["+ids+"]",'_blank');
                                            //window.location.replace("{{ Route("reagent.reagents.report", 0) }}");
                                        }
                                        else
                                        {
                                            bootbox.alert({
                                                message: "Seleccione al menos un reactivo para continuar!",
                                                buttons: {
                                                    'ok': {
                                                        label: 'Cerrar',
                                                        className: 'btn-danger'
                                                    }
                                                }
                                            });
                                        }
                                    }
                                },
                                @endif
                            ]
                        },
                    @else // Con boton de agregar nuevo
                        dom: '<"clearfix"<"pull-right tableTools-container"<"btn-group btn-overlap"T>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
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
                            /*
                            {
                                sExtends: "print",
                                sToolTip: "Vista de Impresión",
                                sButtonClass: "btn btn-white btn-primary  btn-bold",
                                sButtonText: "<i class='fa fa-print bigger-110 grey'></i>",
                                bShowAll: true,
                                sMessage: "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small></small></a></div></div>",

                                sInfo: "<h3 class='no-margin-top'>Vista de Impresión</h3>\
                                          <p>Por favor utilice la función de impresión de su navegador para imprimir esta tabla.\
                                            <br />Oprima <b>esc</b> cuando finalize.</p>",
                                fnClick: function ( e, dt, node, config ) {
                                    var f = this.s.dt;
                                    $('#small-title').css("display", "none");
                                    $('#_dataTable_wrapper .clearfix').css("display", "none");
                                    $('#_dataTable_wrapper .dataTables_wrapper .row').css("display", "none");
                                    f._iDisplayLength = f.fnRecordsDisplay();
                                    f.oApi._fnDraw(f);
                                    window.print();
                                    $('#small-title').css("display", "inline-block");
                                    $('#_dataTable_wrapper .clearfix').css("display", "block");
                                    $('#_dataTable_wrapper .dataTables_wrapper .row').css("display", "block");
                                    f._iDisplayLength = 10;
                                    f.oApi._fnDraw(f);
                                }
                            }
                            */
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

