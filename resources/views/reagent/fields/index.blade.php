@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Campos de Conocimiento')

@section('contenido')
    <?php
        $usetable = 1;
        $columnas = array("NOMBRE", "DESCRIPCION", "ACTIVO");
    ?>
    <input hidden type="text" id="url" value="{{ route('reagent.fields.data') }}">
    <div class="table-responsive" style="border: none">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>¿Activo?</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
{{--

@push('table-script')
    <script>
        $(function() {
            var url = $('#url').val();
            $('#_dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: url,
                columns: [
                    @foreach ($columnas as $col)
                        { data: '{{ $col }}', name: '{{ $col }}' },
                    @endforeach
                    { data: 'ACTION', name: 'ACTION', orderable: false, searchable: false }
                ],
                sorting: [[1, 'asc']],
                dom: '<"clearfix"<"pull-left tableTools-container"<"btn-group btn-overlap"T>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
                tableTools: {
                    sSwfPath: "{{ asset('ace/swf/copy_csv_xls_pdf.swf') }}",
                    sSelectedClass: "success",
                    aButtons: [
                        {
                            sExtends: "copy",
                            sToolTip: "Copiar al Portapapeles",
                            sButtonClass: "btn btn-white btn-primary btn-bold",
                            sButtonText: "<i class='fa fa-copy bigger-110 pink'></i>"
                        },
                        {
                            sExtends: "xls",
                            sToolTip: "Exportar a Excel",
                            sButtonClass: "btn btn-white btn-primary  btn-bold",
                            sButtonText: "<i class='fa fa-file-excel-o bigger-110 green'></i>"
                        },

                        {
                            sExtends: "csv",
                            sToolTip: "Exportar a CSV",
                            sButtonClass: "btn btn-white btn-primary  btn-bold",
                            sButtonText: "<i class='fa fa-file-text-o bigger-110 gray'></i>"
                        },

                        {
                            sExtends: "pdf",
                            sToolTip: "Exportar a PDF",
                            sButtonClass: "btn btn-white btn-primary  btn-bold",
                            sButtonText: "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
                        },

                        {
                            sExtends: "print",
                            sToolTip: "Vista de Impresión",
                            sButtonClass: "btn btn-white btn-primary  btn-bold",
                            sButtonText: "<i class='fa fa-print bigger-110 grey'></i>",

                            sMessage: "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small></small></a></div></div>",

                            sInfo: "<h3 class='no-margin-top'>Vista de Impresión</h3>\
									  <p>Por favor utilice la función de impresión de su navegador para imprimir esta tabla.\
									  <br />Oprima <b>esc</b> cuando finalize.</p>",
                        }
                    ]
                },
                language: {
                    sProcessing:     "Procesando...",
                    sLengthMenu:     "Mostrar _MENU_ registros",
                    sZeroRecords:    "No se encontraron resultados",
                    sEmptyTable:     "Ningún dato disponible en esta tabla",
                    sInfo:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    sInfoPostFix:    "",
                    sSearch:         "Buscar:",
                    sUrl:            "",
                    sInfoThousands:  ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Último",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    },
                    oAria: {
                        sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sSortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
@endpush
--}}
