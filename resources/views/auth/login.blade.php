<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>Inicio de Sesi&oacute;n - Reactivos UPS</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    {!! HTML::style('ace/css/bootstrap.min.css') !!}
    {!! HTML::style('ace/font-awesome/4.2.0/css/font-awesome.min.css') !!}

    <!-- text fonts -->
    {!! HTML::style('ace/fonts/fonts.googleapis.com.css') !!}

    <!-- ace styles -->
    {!! HTML::style('ace/css/ace.min.css') !!}

    <!--[if lte IE 9]>
    <!--
    <link rel="stylesheet" href="ace/css/ace-part2.min.css" />
    -->
    <!--[endif]-->
    {!! HTML::style('ace/css/ace-rtl.min.css') !!}

    <!--[if lte IE 9]>
    <!--
    <link rel="stylesheet" href="ace/css/ace-ie.min.css" />
    -->
    <!--[endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <!--
    <script src="ace/js/html5shiv.min.js"></script>
    <script src="ace/js/respond.min.js"></script>
    -->
    <!--[endif]-->

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body class="login-layout light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="space-16"></div>
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <img src="{{ asset('image/logo-ups-home.png') }}" alt="Universidad Polit&eacute;cnica Salesiana">
                        </div>

                        <div class="space-6"></div>

                        <div class="center">
                            @include('flash::message')
                        </div>

                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-coffee green"></i>
                                            Ingrese su Informaci&oacute;n
                                        </h4>

                                        <div class="space-6"></div>

                                        {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'auth.login','method' => 'POST']) !!}
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input id="username" name="username" type="text" class="form-control" placeholder="Correo Institucional" required/>
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input id="password" name="password" type="password" class="form-control" placeholder="Contrase&ntilde;a" required/>
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>

                                                <div id="perfiles" hidden>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <select id="profile" name="profile" class="form-control">
                                                            </select>
                                                        </span>
                                                    </label>
                                                </div>

                                                <div class="space"></div>

                                                <div id="alerta" style="width: 100%; {{ !isset($message) ? "display: none" : "" }}">
                                                    <div id="text" class="alert alert-danger center" style="padding: 5px; width: 100%;">{{ isset($message) ? $message : "" }}</div>
                                                    <div class="space"></div>
                                                </div>

                                                <div class="clearfix">
                                                    <label style="display: none;">
                                                        <input id="rememberMe" name="rememberMe" type="checkbox" class="ace" />
                                                        <span class="lbl">Recu&eacute;rdame</span>
                                                    </label>

                                                    <button id="btnLogin" type="submit" class="width-45 pull-right btn btn-sm btn-primary" >
                                                        <i class="ace-icon fa fa-key"></i>
                                                        <span class="bigger-110">Iniciar Sesi&oacute;n</span>
                                                    </button>
                                                </div>

                                                <div class="space-4"></div>
                                            </fieldset>
                                        {!! Form::close() !!}

                                    </div><!-- /.widget-main -->

                                    <div class="toolbar clearfix">
                                        <div>
                                            <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                Olvid&eacute; mi contrase&ntilde;a
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->

                            <div id="forgot-box" class="forgot-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header red lighter bigger">
                                            <i class="ace-icon fa fa-key"></i>
                                            Recuperar Contrase&ntilde;a
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>
                                            Ingrese su Correo Institucional
                                        </p>

                                        {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'auth.forgot','method' => 'POST']) !!}
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input id="username2" name="username2" type="email" class="form-control" placeholder="Correo Institucional" />
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>

                                                <div class="clearfix">
                                                    <button id="btnSend" type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                        <i class="ace-icon fa fa-lightbulb-o"></i>
                                                        <span class="bigger-110">Enviar</span>
                                                    </button>
                                                </div>
                                            </fieldset>
                                        {!! Form::close() !!}
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            Regresar a inicio de sesi&oacute;n
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.forgot-box -->

                        </div><!-- /.position-relative -->

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->
    {!! HTML::script('ace/js/jquery.2.1.1.min.js') !!}
    <script type="text/javascript">
        window.jQuery || document.write("<script src='ace/js/jquery.min.js'>"+"<"+"/script>");
    </script>
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    {!! HTML::script('ace/js/bootstrap.min.js') !!}

    <!-- inline scripts related to this page -->
    {!! HTML::script('scripts/login/index.js') !!}

    <script type="text/javascript">
        $("#username").on("focusout", function () {
            $.ajax({
                type: 'GET',
                url: "{{ route('auth.userprofiles') }}",
                data: { username: $("#username").val() },
                dataType: "json",
                async: true,
                cache: false,
                error: function (e) {
                    console.log('Error:');
                    console.log(e);
                },
                success: function (r) {
                    if (r.valid) {
                        var p = r.profiles;

                        if(p.length > 1)
                            $("#perfiles").attr('hidden', false);

                        $("#profile").find('option').remove();
                        for(var i = 0; i < p.length; i++){
                            $("#profile").append('<option value="'+p[i].id+'">'+p[i].nombre+'</option>');
                        }
                    }
                    else {
                        $("#perfiles").attr('hidden', true);
                        $("#alerta #text").html(r.message);
                        $("#alerta").css("display", "");
                    }
                }
            });
        });
    </script>

</body>
</html>
