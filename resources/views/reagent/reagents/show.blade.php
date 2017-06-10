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
                        <div class="form-group">
                            <div class="col-sm-2"><strong>C&oacute;digo:</strong></div>
                            <div class="col-sm-8">{{ $reagent->id }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Campus:</strong></div>
                            <div class="col-sm-8">{{ $reagent->distributive->matterCareer->careerCampus->campus->descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Carrera:</strong></div>
                            <div class="col-sm-8">{{ $reagent->distributive->matterCareer->careerCampus->career->descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Menci&oacute;n:</strong></div>
                            <div class="col-sm-8">{{ $reagent->distributive->matterCareer->mention->descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Materia:</strong></div>
                            <div class="col-sm-8">{{ $reagent->distributive->matterCareer->matter->descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Responsable:</strong></div>
                            <div class="col-sm-8">{{ $reagent->user->FullName }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Estado:</strong></div>
                            <div class="col-sm-8">{{ $reagent->state->descripcion }}</div>
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
                                                <img class="img-responsive" src="{{ route('reagent.reagents.image', $reagent->id) }}" style="max-width: 600px; width: 100%;" />
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
                        <div class="form-group">
                            <div class="col-sm-2"><strong>Campo de Conocimiento:</strong></div>
                            <div class="col-sm-8">{{ $reagent->field->nombre }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Dificultad:</strong></div>
                            <div class="col-sm-8">{{ ($reagent->dificultad == 'B') ? 'Baja' : ($reagent->dificultad == 'M') ? 'Media' : 'Alta' }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Operacion Cognitiva:</strong></div>
                            <div class="col-sm-8">{{ $reagent->descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Referencia:</strong></div>
                            <div class="col-sm-8">{{ $reagent->referencia }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Creado por:</strong></div>
                            <div class="col-sm-4">{{ $reagent->user->FullName }}</div>
                            <div class="col-sm-2"><strong>Fecha de creación:</strong></div>
                            <div class="col-sm-4">{{ $reagent->fecha_creacion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Modificado por:</strong></div>
                            <div class="col-sm-4">{{ isset($reagent->updaterUser->FullName) ? $reagent->updaterUser->FullName : '' }}</div>
                            <div class="col-sm-2"><strong>Fecha de modificación:</strong></div>
                            <div class="col-sm-4">{{ $reagent->fecha_modificacion }}</div>
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
    <script type="text/javascript">
        jQuery(function($) {
            var $overflow = '';
            var colorbox_params = {
                rel: 'colorbox',
                reposition:true,
                scalePhotos:true,
                scrolling:false,
                previous:'<i class="ace-icon fa fa-arrow-left"></i>',
                next:'<i class="ace-icon fa fa-arrow-right"></i>',
                close:'&times;',
                current:'{current} of {total}',
                maxWidth:'100%',
                maxHeight:'100%',
                onOpen:function(){
                    $overflow = document.body.style.overflow;
                    document.body.style.overflow = 'hidden';
                },
                onClosed:function(){
                    document.body.style.overflow = $overflow;
                },
                onComplete:function(){
                    $.colorbox.resize();
                }
            };

            $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
            $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


            $(document).one('ajaxloadstart.page', function(e) {
                $('#colorbox, #cboxOverlay').remove();
            });
        })
    </script>
@endpush