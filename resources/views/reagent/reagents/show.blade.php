@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Detalle de reactivo')

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
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n General
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse in" id="collapseOne">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-2"><strong>C&oacute;digo:</strong></div>
                            <div class="col-sm-8">{{ $reagent->id }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Campus:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_campus }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Carrera:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_carrera }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Menci&oacute;n:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_mencion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Materia:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_materia }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Responsable:</strong></div>
                            <div class="col-sm-8">{{ $reagent->usr_responsable }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Estado:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_estado }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n de Reactivo
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse" id="collapseTwo">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-2"><strong>Formato:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_formato }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Contenido:</strong></div>
                            <div class="col-sm-8">{{ $reagent->desc_contenido }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Planteamiento:</strong></div>
                            <div class="col-sm-8">{{ $reagent->planteamiento }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12"><strong>Opciones de Pregunta:</strong></div>
                        </div>
                        <div class="form-group">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td><strong>Concepto</strong></td>
                                    <td><strong>Propiedad</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>{{ $question->secuencia }}</td>
                                        <td>{{ $question->concepto }}</td>
                                        <td>{{ $question->propiedad }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12"><strong>Opciones de Respuesta:</strong></div>
                        </div>
                        <div class="form-group">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td><strong>Descripcion</strong></td>
                                    <td><strong>Argumento</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($answers as $answer)
                                    <tr>
                                        <td>{{ $answer->secuencia }}</td>
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
                            <div class="col-sm-8">{{ $reagent->desc_campo }}</div>
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
                            <div class="col-sm-4">{{ $reagent->creado_por }}</div>
                            <div class="col-sm-2"><strong>Fecha de creación:</strong></div>
                            <div class="col-sm-4">{{ $reagent->fecha_creacion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Modificado por:</strong></div>
                            <div class="col-sm-4">{{ $reagent->modificado_por }}</div>
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
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <td><strong>Fecha</strong></td>
                                    <td><strong>Creado por</strong></td>
                                    <td><strong>Comentario</strong></td>
                                    <td><strong>Estado Nuevo</strong></td>
                                    <td><strong>Estado Anterior</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->fecha_creacion }}</td>
                                        <td>{{ $users[$comment->creado_por] }}</td>
                                        <td>{{ $comment->comentario }}</td>
                                        <td>{{ $states[$comment->id_estado_nuevo] }}</td>
                                        <td>{{ $states[$comment->id_estado_anterior] }}</td>
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