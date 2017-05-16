@extends('test.template')

@section('usuario')
    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <span class="user-info">
                                <small>Bienvenido,</small>
                                {{ $test->nombres }}
                            </span>

            <i class="ace-icon fa fa-caret-down"></i>
        </a>

        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
                <a href="{{ route('auth.login') }}">
                    <i class="ace-icon fa fa-power-off"></i>
                    Salir
                </a>
            </li>
        </ul>
    </li>
@endsection

@section('contenido')

@endsection