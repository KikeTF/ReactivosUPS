@extends('test.template')

@section('contenido')

    <form class="form-horizontal" role="form">

        <div class="pull-right">
            <button class="btn btn-success" onclick="location.href='{{ route('test.create') }}'; return false;">
                Siguiente<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
            </button>
        </div>

    </form>
@endsection