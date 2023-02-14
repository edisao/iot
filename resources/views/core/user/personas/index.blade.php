@extends('layouts.main')
@section('page_title', trans('labels.personas'))

@section('css_datatable')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}">
@endSection

@section('css')
    .pull-derecha {
        text-align: right!important;
    }
@endSection

@section('page_content')
    <!-- Content Page header -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.personas') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ trans('labels.personas') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    <p>
                        <a href="/personas/create" class="btn btn-white btn-bitbucket">
                            <i class="fa fa-plus-circle"></i> {{ trans('labels.nuevo') }}
                        </a>
                        <a href="{{ route('personas.batch') }}" class="btn btn-white btn-bitbucket">
                            <i class="fa fa-gears"></i> {{ trans('labels.batch') }}
                        </a>
                    </p>
                    <div class="table-responsive">
                        <table id="tableData" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('labels.id') }}</th>
                                    <th>{{ trans('labels.nombres') }}</th>
                                    <th>{{ trans('labels.apellidos') }}</th>
                                    <th>{{ trans('labels.identificacion') }}</th>
                                    <th>{{ trans('labels.fechaNacimiento') }}</th>
                                    <th>{{ trans('labels.telefono') }}</th>
                                    <th>{{ trans('labels.mail') }}</th>
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
    </div>

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
        var titleExportDocument = "{{ trans('labels.personas') }}";
        $("#tableData").DataTable({
            "paging":   true,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
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
                }, 'copy', 'print'
            ],
            select: true,
            responsive: true,
            //'bAutoWidth': true,
            //'lengthChange': true,
            //'autoWidth': true,
            //'ordering': false,
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 50,
            'ajax':"{{route('personas.data')}}",
            'columns':[
                {data:'id'},
                {data:'nombres'},
                {data:'apellidos'},
                {data:'identificacion'},
                {data:'fecha_nacimiento'},
                {data:'telefono'},
                {data:'mail_principal'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 50},
            ]
        });
        /* End Script Datatable */

    });
</script>

@endSection