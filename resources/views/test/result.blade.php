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

    <div>

        <div class="page-header" style="text-align: center;">
            <h2>Resultados</h2>
        </div>

        <br/>
        <div class="row" align="center">
            <div class="clearfix" style="max-width: 178px;">
                <div class="grid2" style="width: 84px; text-align: center;">
                    <span class="bigger-175 blue">{{ $test->reactivos_acertados }}</span>
                    <br>
                    <strong>Aciertos</strong>
                </div>
                <div class="grid2" style="width: 84px; text-align: center;">
                    <span class="bigger-175 red">{{ $test->reactivos_errados }}</span>
                    <br>
                    <strong>Fallos</strong>
                </div>
            </div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-xs-12 center">
                <div class="knob-container inline">
                    <?php $puntaje = round(100*$test->reactivos_acertados/$test->answersDetails->count());?>
                    <input type="text"
                           class="input-small knob"
                           value="{{ $puntaje }}"
                           data-min="0" data-max="100"
                           data-step="10"
                           data-width="150"
                           data-height="150"
                           data-thickness=".2"
                           data-fgcolor="{{ ($puntaje == 100) ? '#87B87F' : ( ($puntaje < 70) ? '#dd5a43' : '#478fca' ) }}" />
                </div>
                <br>
                <strong><span class="bigger-175">{{ ($puntaje >= 70) ? 'Aprobado' : 'Reprobado' }}</span></strong>
            </div>
        </div>

    </div>
@endsection

@push('specific-script')
    <script type="text/javascript">
        $(".knob").knob({
            draw : function(){
                $(".knob").css("font-size","45px");
            }
        });

    </script>
@endpush