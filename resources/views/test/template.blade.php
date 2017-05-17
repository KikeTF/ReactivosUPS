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
    <link rel="stylesheet" href="{{ asset('ace/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ace/font-awesome/4.2.0/css/font-awesome.min.css') }}" />

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('ace/fonts/fonts.googleapis.com.css') }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('ace/css/ace.min.css') }}" />

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
                <a href="/" class="navbar-brand">
                    <small>
                        <i class="fa fa-graduation-cap"></i>
                        Reactivos UPS
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
    </div>

    <script src="{{ asset('ace/js/jquery.2.1.1.min.js') }}"></script>

    <script type="text/javascript">
        window.jQuery || document.write("<script src='ace/js/jquery.min.js'>"+"<"+"/script>");
    </script>

    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="{{ asset('ace/js/bootstrap.min.js') }}"></script>

    <!-- ace scripts -->
    <script src="{{ asset('ace/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('ace/js/ace.min.js') }}"></script>

    <script src="{{ asset('ace/js/jquery.knob.min.js') }}"></script>

    @stack('specific-script')
</body>
</html>