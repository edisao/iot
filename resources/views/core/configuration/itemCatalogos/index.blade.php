@extends('layouts.main')
@section('page_title', trans('labels.itemCatalogos'))

@section('css_datatable')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}">
@endSection

@section('page_content')
    <!-- Content Page header -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.itemCatalogos') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('catalogos.index') }}">{{ trans('labels.catalogos') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ trans('labels.itemCatalogos') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    <h3><strong>{{$catalogo->nombre . ' (' . $catalogo->codigo. ')'}}</strong></h3>
                    
                    <p>
                        <a href="{{ route ('itemCatalogos.create', ['catalogo' => $catalogo ]) }}" class="btn btn-white btn-bitbucket">
                            <i class="fa fa-plus-circle"></i> {{ trans('labels.nuevo') }}
                        </a>
                    </p>
                    <table id="tableData" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>{{ trans('labels.id') }}</th>
                                <th>{{ trans('labels.codigo') }}</th>
                                <th>{{ trans('labels.nombre') }}</th>
                                <th>{{ trans('labels.valor') }}</th>
                                <th>{{ trans('labels.descripcion') }}</th>
                                <th>{{ trans('labels.opciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    @include('layouts.partials.delete-confirm')
    <!-- /.footer -->

@endsection

@section('js_datatable')
<script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/dataTables.responsive.js') }}"></script>
@endSection

@section('script')
<script>
    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-white btn-sm';
    $(function() {

        /* Init Script Datatable */
        var titleExportDocument = "{{ trans('labels.itemCatalogos') }}";
        $("#tableData").DataTable({
            'responsive': true,
            'bAutoWidth': false,
            'lengthChange': true,
            'autoWidth': false,
            //'ordering': false,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 50,
            'ajax':"{{ route('itemCatalogos.data', ['catalogoId' => $catalogo->id]) }}",
            'buttons': [{
                    extend: 'csv',
                    title: titleExportDocument
                },
                {
                    extend: 'excel',
                    title: titleExportDocument
                },
                {
                    extend: 'pdf',
                    title: titleExportDocument
                }, 'copy', 'print',
            ],
            'columns':[
                {data:'id'},
                {data:'codigo'},
                {data:'nombre'},
                {data:'valor'},
                {data:'descripcion'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 120},
            ]
        });
        /* End Script Datatable */

    });
</script>

@endSection