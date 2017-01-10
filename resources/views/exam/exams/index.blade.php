@extends('shared.templates.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Generaci&oacute;n de Examen')

@section('contenido')

    <form class="form-horizontal" role="form">


        <div id="right-menu" class="modal aside" data-body-scroll="false" data-offset="true" data-placement="right" data-fixed="true" data-backdrop="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header no-padding">
                        <div class="table-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span class="white">&times;</span>
                            </button>
                            Listado de Materias
                        </div>
                    </div>

                    <div class="modal-body">
                        <h3 class="lighter">Custom Elements and Content</h3>

                        <br />
                        With no modal backdrop
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        1
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        2
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        3
                    </div>
                </div><!-- /.modal-content -->

                <button class="aside-trigger btn btn-info btn-app btn-xs ace-settings-btn" data-target="#right-menu" data-toggle="modal" type="button">
                    <i data-icon1="fa-plus" data-icon2="fa-minus" class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                </button>
            </div><!-- /.modal-dialog -->
        </div>

    </form>

@endsection

@push('specific-script')
    <script type="text/javascript">
        jQuery(function($) {
            $('.modal.aside').ace_aside();

            $('#aside-inside-modal').addClass('aside').ace_aside({container: '#my-modal > .modal-dialog'});

            $(document).one('ajaxloadstart.page', function(e) {
                //in ajax mode, remove before leaving page
                $('.modal.aside').remove();
                $(window).off('.aside')
            });
        })
    </script>
@endpush