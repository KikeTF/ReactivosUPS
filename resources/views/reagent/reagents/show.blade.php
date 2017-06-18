@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Detalle de reactivo')

@push('specific-styles')
    <link rel="stylesheet" href="{{ asset('ace/css/colorbox.min.css') }}" />
@endpush

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
            if( in_array($reagent->id_estado, array(1, 4)) )
                $btnedit = route('reagent.reagents.edit', $reagent->id);

            $btnprint =  route("reagent.reagents.report", $reagent->id);
            $btnclose = route('reagent.reagents.index');
        ?>
        @include('shared.templates._formbuttons')

        <div id="accordion" class="accordion-style1 panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n General
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse" id="collapseOne">
                    <div class="panel-body">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">C&oacute;digo</div>
                                <div class="profile-info-value"><span>{{ $reagent->id }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Campus</div>
                                <div class="profile-info-value"><span>{{ $reagent->distributive->matterCareer->careerCampus->campus->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Carrera</div>
                                <div class="profile-info-value"><span>{{ $reagent->distributive->matterCareer->careerCampus->career->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Menci&oacute;n</div>
                                <div class="profile-info-value"><span>{{ $reagent->distributive->matterCareer->mention->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Materia</div>
                                <div class="profile-info-value"><span>{{ $reagent->distributive->matterCareer->matter->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Responsable</div>
                                <div class="profile-info-value"><span>{{ $reagent->user->FullName }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Estado</div>
                                <div class="profile-info-value"><span>{{ $reagent->state->descripcion }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n de Reactivo
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse in" id="collapseTwo">
                    <div class="panel-body">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">Formato</div>
                                <div class="profile-info-value"><span>{{ $reagent->format->nombre }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Contenido</div>
                                <div class="profile-info-value"><span>{{ $reagent->contentDetail->ContentDescription }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Planteamiento</div>
                                <div class="profile-info-value" style="text-align: justify;">
                                    <span >{{ $reagent->planteamiento }}</span>

                                    @if($reagent->imagen == 'S')
                                        <div class="space-6"></div>
                                        <ul class="ace-thumbnails clearfix">
                                            <li>
                                                <a href="{{ route('reagent.reagents.image', $reagent->id) }}" data-rel="colorbox">
                                                    <img class="img-responsive" src="{{ route('reagent.reagents.image', $reagent->id) }}" style="max-width: 300px; width: 100%;" />
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="space-4"></div>
                                    @endif

                                    @if($reagent->format->opciones_pregunta == 'S')
                                        <div class="space-6"></div>
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <div class="col-sm-6">
                                                <table id="table-show" class="table">
                                                    <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td>Concepto</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($reagent->questionsConcepts as $question)
                                                        <tr>
                                                            <td style="width: 40px;">{{ $question->numeral.'.' }}</td>
                                                            <td>{{ $question->concepto }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if($reagent->format->concepto_propiedad == 'S')
                                                <div class="col-sm-6">
                                                    <table id="table-show" class="table">
                                                        <thead>
                                                        <tr>
                                                            <td></td>
                                                            <td>Propiedad</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($reagent->questionsProperties as $question)
                                                            <tr>
                                                                <td style="width: 40px;">{{ $question->literal.'.' }}</td>
                                                                <td>{{ $question->propiedad }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">
                                    Opciones de Respuesta<br/>
                                    (<i class="fa fa-check green" aria-hidden="true"></i>) Opci&oacute;n Correcta
                                </div>
                                <div class="profile-info-value">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <div class="col-sm-12">
                                            <table id="table-show" class="table">
                                                <thead>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td>Descripcion</td>
                                                    <td>Argumento</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($reagent->answers as $answer)
                                                    <tr style="{{ ($answer->opcion_correcta == 'S') ? 'background-color: #dff0d8;' : '' }}">
                                                        <td style="width: 35px;">
                                                            @if($answer->opcion_correcta == 'S')
                                                                <i class="fa fa-check green" aria-hidden="true"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 40px;">{{ $answer->numeral.'.' }}</td>
                                                        <td>{{ $answer->descripcion }}</td>
                                                        <td>{{ $answer->argumento }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n Complementaria
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse" id="collapseThree">
                    <div class="panel-body">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">Campo de Conocimiento</div>
                                <div class="profile-info-value"><span>{{ $reagent->field->nombre }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Dificultad</div>
                                <div class="profile-info-value"><span>{{ ($reagent->dificultad == 'B') ? 'Baja' : ($reagent->dificultad == 'M') ? 'Media' : 'Alta' }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Operaci&oacute;n Cognitiva</div>
                                <div class="profile-info-value"><span>{{ $reagent->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Referencia</div>
                                <div class="profile-info-value"><span>{{ $reagent->referencia }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Creado por</div>
                                <div class="profile-info-value"><span>{{ $reagent->user->FullName }}</span></div>
                                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                                <div class="profile-info-value"><span>{{ $reagent->fecha_creacion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Modificado por</div>
                                <div class="profile-info-value"><span>{{ isset($reagent->updaterUser->FullName) ? $reagent->updaterUser->FullName : '' }}</span></div>
                                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                                <div class="profile-info-value"><span>{{ $reagent->fecha_modificacion }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Comentarios
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse" id="collapseFour">
                    <div class="panel-body">
                        <div class="form-group">
                            <table id="table-show" class="table table-hover">
                                <thead>
                                <tr>
                                    <td>Fecha</td>
                                    <td>Creado por</td>
                                    <td>Comentario</td>
                                    <td>Estado</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reagent->comments->sortByDesc('id') as $comment)
                                    <tr>
                                        <td>{{ $comment->fecha_creacion }}</td>
                                        <td>{{ $comment->user->FullName }}</td>
                                        <td class="col-sm-5">{{ $comment->comentario }}</td>
                                        <td>{{ $comment->state->descripcion }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('specific-script')
    <script src="{{ asset('ace/js/jquery.colorbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/reagent/reagents/common.js') }}"></script >
    <script type="text/javascript">
        $(window).load(function() {
            imagePropertiesLoad();
        });
    </script >
@endpush