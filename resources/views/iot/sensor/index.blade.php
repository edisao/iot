@extends('layouts.main')
@section('page_title', trans('labels.sensores'))

@section('css_datatable')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}">
@endSection

@section('page_content')
    <!-- Content Page header -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.sensores') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ trans('labels.sensores') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    
                    <form role="form" name="FormDataSensor" id="FormDataSensor" 
                        action="{{ route('iots.deleteData') }}" 
                        method="POST" 
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <input type="checkbox" onClick="toggleData(this)" class="" id="SeleccionarTodos" name="SeleccionarTodos">
                        <label class="form-check-label strong" for="SeleccionarTodos">{{ trans('labels.seleccionarTodos') }}</label>
                        <div class="hr-line-dashed"></div>

                            <table id="tableData" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ trans('labels.sensores') }}</th>
                                        <th>{{ trans('labels.tipos') }}</th>
                                        <th>{{ trans('labels.valor') }}</th>
                                        <th>{{ trans('labels.fecha') }}</th>
                                        <th>{{ trans('labels.opciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            @error('notificaciones')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                            <div>
                                <button type="submit" class="btn btn-danger">{{ trans('labels.eliminar') }}</button>
                            </div>
                    </form>
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
    function toggleData(source) {
        checkboxes = document.getElementsByName('datos[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
    $(function() {

        /* Init Script Datatable */
        var titleExportDocument = "{{ trans('labels.sensores') }}";
        $("#tableData").DataTable({
            'responsive': true,
            'bAutoWidth': false,
            'lengthChange': true,
            'autoWidth': false,
            //'ordering': false,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 100,
            'ajax':"{{route('iots.data')}}",
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
                }, 'copy', 'print', 'colvis'
            ],
            'columns':[
                {data:'chk'},    
                {data:'sensor_code'},
                {data:'tipo_nombre'},
                {data:'value'},
                {data:'fecha_registro'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 120},
            ]
        });
        /* End Script Datatable */

    });
</script>

@endSection