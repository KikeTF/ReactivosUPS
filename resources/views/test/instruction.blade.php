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
                <a href="{{ route('test.destroy', $test->id) }}">
                    <i class="ace-icon fa fa-power-off"></i>
                    Salir
                </a>
            </li>
        </ul>
    </li>
@endsection

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => 'test.store',
            'method' => 'POST']) !!}

        <div class="page-header">
            <h4 style="padding: 0; margin: 0;">Disposiciones Generales</h4>
        </div>

        {!! Form::hidden('id', $test->id) !!}

        <div class="form-group">
            <div class="col-md-6 col-md-offset-3" style="text-align: justify; line-height: 24px; font-size: 14px;">
                {{--{!! nl2br(e($test->parameter->instrucciones)) !!}--}}
                {!! htmlspecialchars_decode($test->parameter->instrucciones) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-11">
                <div id="actions-bottons" class="pull-right">
                    <button type="submit" class="btn btn-success btn-next">
                        Siguiente
                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    </button>
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@endsection