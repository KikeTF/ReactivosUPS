@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Campos de Conocimiento')

@section('contenido')
    <div class="table-responsive" style="border: none">
        <table id="fields-table" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <!--
                    <th class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    -->
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>¿Activo?</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#fields-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'http://localhost:8000/reagent/fields/data',
                columns: [
                    { data: 'NOMBRE', name: 'NOMBRE' },
                    { data: 'DESCRIPCION', name: 'DESCRIPCION' },
                    { data: 'ACTIVO', name: 'ACTIVO' },
                    { data: 'ACTION', name: 'ACTION', orderable: false, searchable: false }
                ],
                sorting: [[1, 'asc']],
                dom: '<"clearfix"<"pull-right tableTools-container"<"btn-group btn-overlap"T>>><"dataTables_wrapper"<"row"<"col-xs-6"l><"col-xs-6"f><r>>t<"row"<"col-xs-6"i><"col-xs-6"p>>>',
                tableTools: {
                    sSwfPath: "{{ asset('ace/swf/copy_csv_xls_pdf.swf') }}",
                    sSelectedClass: "success",
                    aButtons: [
                        {
                            sExtends: "copy",
                            sToolTip: "Copiar al Portapapeles",
                            sButtonClass: "btn btn-white btn-primary btn-bold",
                            sButtonText: "<i class='fa fa-copy bigger-110 pink'></i>",
                            fnComplete: function() {
                                this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
                                        1500
                                );
                            }
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
                }
            });
        });
    </script>
@endpush
