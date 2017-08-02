<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>Examen de Prueba</title>

    <meta name="description" content="Test exam page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    {!! HTML::style('ace/css/bootstrap.min.css') !!}
    {!! HTML::style('ace/font-awesome/4.2.0/css/font-awesome.min.css') !!}

    <!-- text fonts -->
    {!! HTML::style('ace/fonts/fonts.googleapis.com.css') !!}

    <!-- ace styles -->
    {!! HTML::style('ace/css/ace.min.css') !!}

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- specific styles -->
    @stack('specific-styles')

</head>

<body class="no-skin">

    <div id="navbar" class="navbar navbar-default navbar-fixed-top">
        <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
        </script>

        <div class="navbar-container" id="navbar-container">
            <div class="navbar-header pull-left">
                <a href="{{ route('test.create') }}" class="navbar-brand">
                    <small>
                        <i class="fa fa-graduation-cap"></i>
                        Simulador de Examen Complexivo
                    </small>
                </a>
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
                    @yield('usuario')
                </ul>
            </div>
        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>

        <div class="main-content">
            <div class="main-content-inner">

                    <div class="page-content">
                        <section>
                            @include('flash::message')
                            @yield('contenido')
                        </section>
                    </div>

            </div>
        </div>

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
    </div>

    <script src="{{ asset('ace/js/jquery.2.1.1.min.js') }}"></script>

    <script type="text/javascript">
        window.jQuery || document.write("<script src='ace/js/jquery.min.js'>"+"<"+"/script>");
    </script>

    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    {!! HTML::script('ace/js/bootstrap.min.js') !!}

    <!-- ace scripts -->
    {!! HTML::script('ace/js/ace-elements.min.js') !!}
    {!! HTML::script('ace/js/ace.min.js') !!}
    {!! HTML::script('ace/js/jquery.knob.min.js') !!}

    @stack('specific-script')
</body>
</html>