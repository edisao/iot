@extends('layouts.main')
@section('page_title', trans('msg.msgEditarInformacion') )

@section('css_daterangepicker')
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}">
@endsection

@section('css_select2')
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2-bootstrap4.min.css') }}">
@endSection

@section('css_datatable')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}">
@endSection

@section('page_content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.usuarios') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/usuarios/">{{ trans('labels.usuarios') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ trans('labels.editar') }}
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ $persona->nombres . ' ' . $persona->apellidos }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    <h1>{{$persona->nombres . ' ' . $persona->apellidos}}</h1>
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">{{ trans('labels.informacion') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabsContent">
                                <div id="tab-1" class="tab-pane fade show active" role="tabpanel">
                                    <form role="form" name="FormUsuario" id="FormUsuario" action="{{route('usuarios.update',$usuario)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="Nombres">{{ trans('labels.nombre') }}</label>
                                            <input type="text" class="form-control" id="Nombres" name="Nombres" value="{{old('Nombres', $persona->nombres )}}" maxlength="50" autocomplete="off" placeholder="" required>
                                            @error('Nombres')
                                            <span class="small text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Apellidos">{{ trans('labels.apellidos') }}</label>
                                            <input type="text" class="form-control" id="Apellidos" name="Apellidos" value="{{old('Apellidos', $persona->apellidos )}}" maxlength="200" autocomplete="off" placeholder="" required>
                                            @error('Apellidos')
                                            <span class="small text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Identificacion">{{ trans('labels.identificacion') }}</label>
                                            <input type="text" class="form-control" id="Identificacion" name="Identificacion" value="{{old('Identificacion', $persona->identificacion )}}" maxlength="20" autocomplete="off" placeholder="" >
                                            @error('Identificacion')
                                            <span class="small text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('labels.fechaNacimiento') }}</label>
                                            <input type="text" class="form-control" id="FechaNacimiento" name="FechaNacimiento" value="{{old('FechaNacimiento', (!empty($persona->fecha_nacimiento)) ? date('d/m/Y', strtotime($persona->fecha_nacimiento)) : '' )}}" autocomplete="off" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="Telefono">{{ trans('labels.telefono') }}</label>
                                            <input type="text" class="form-control" id="Telefono" name="Telefono" value="{{old('Telefono', $persona->telefono )}}" maxlength="50" autocomplete="off" placeholder=""  required>
                                            @error('Telefono')
                                            <span class="small text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="TelefonoAdicional">{{ trans('labels.telefonoAdicional') }}</label>
                                            <input type="text" class="form-control" id="TelefonoAdicional" name="TelefonoAdicional" value="{{old('TelefonoAdicional', $persona->telefono_adicional )}}" maxlength="50" autocomplete="off" placeholder="" >
                                            @error('TelefonoAdicional')
                                            <span class="small text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="InformacionAdicional">{{ trans('labels.informacionAdicional') }}</label>
                                            <input type="text" class="form-control" id="InformacionAdicional" name="InformacionAdicional" value="{{old('InformacionAdicional', $usuario->detalle )}}" autocomplete="off" placeholder="" >
                                            @error('InformacionAdicional')
                                            <span class="small text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="AccedePanelAdministracion" name="AccedePanelAdministracion" @if(old('AccedePanelAdministracion', $usuario->accede_panel_administracion)) checked @endif>
                                            <label class="form-check-label" for="AccedePanelAdministracion">{{ trans('labels.accedePanelAdministracion') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="SoloLectura" name="SoloLectura" @if(old('SoloLectura', $usuario->solo_lectura)) checked @endif>
                                            <label class="form-check-label" for="SoloLectura">{{ trans('labels.soloLectura') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="SuperAdministrador" name="SuperAdministrador" @if(old('SuperAdministrador', $usuario->administrador)) checked @endif>
                                            <label class="form-check-label" for="SuperAdministrador">{{ trans('labels.administrador') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="Background" name="Background" @if(old('Background', $usuario->background)) checked @endif>
                                            <label class="form-check-label" for="Background">{{ trans('labels.usuarioBackground') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="NotificarPorMail" name="NotificarPorMail" @if(old('NotificarPorMail', $persona->notificar_por_mail)) checked @endif>
                                            <label class="form-check-label" for="NotificarPorMail">{{ trans('labels.notificarPorMail') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="NotificarPorMensaje" name="NotificarPorMensaje" @if(old('NotificarPorMensaje', $persona->notificar_por_mensaje)) checked @endif>
                                            <label class="form-check-label" for="NotificarPorMensaje">{{ trans('labels.notificarPorMensaje') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="NotificarCumpleanios" name="NotificarCumpleanios" @if(old('NotificarCumpleanios', $persona->notificar_cumpleanos)) checked @endif>
                                            <label class="form-check-label" for="NotificarCumpleanios">{{ trans('labels.notificarCumpleanios') }}</label>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.actualizar') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.delete-confirm')
@endsection

@section('js_validation')
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/additional-methods.min.js') }}"></script>
@endSection

@section('js_select2')
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
@endSection

@section('js_daterangepicker')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}" charset="UTF-8"></script>
@endSection

@section('js_datatable')
<script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/dataTables.responsive.js') }}"></script>
@endSection

@section('script')
<script>
    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-white btn-sm';
    $(function() {
        $('.select2').select2()

        $('#FechaNacimiento').datepicker({
            format: "dd/mm/yyyy",
            weekStart: 0,
            clearBtn: true,
            language: "es",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        });

        // Validacion formulario del Usuario
        $('#FormUsuario').validate({
            rules: {
                Nombres: {
                    required: true,
                },
                Apellidos: {
                    required: true,
                },
                Telefono: {
                    required: true,
                }
            },
            messages: {
                Nombres: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Nombres']) }}",
                },
                Apellidos: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Apellido']) }}",
                },
                Telefono: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Telefono']) }}",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#FormPersonaMail').validate({
            rules: {
                Mail: {
                    required: true,
                    email: true
                }
            },
            messages: {
                Mail: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Mail']) }}",
                    email: "{{ trans('validation.email', [ 'attribute' => 'Mail']) }}",
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#FormPersonaDireccion').validate({
            rules: {
                Pais: {
                    required: true,
                },
                Provincia: {
                    required: true,
                },
                Ciudad: {
                    required: true,
                },
                Direccion: {
                    required: true,
                },
                TelefonoDireccion: {
                    required: true,
                }
            },
            messages: {
                Pais: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Pais']) }}",
                },
                Provincia: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Provincia']) }}",
                },
                Ciudad: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Ciudad']) }}",
                },
                Direccion: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Dirección']) }}",
                },
                TelefonoDireccion: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Teléfono']) }}",
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        var titleExportDocument = "{{ trans('labels.mail') }}";
        $("#tableMailPersona").DataTable({
            'responsive': true,
            'bAutoWidth': false,
            'lengthChange': true,
            'autoWidth': false,
            //'ordering': false,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 50,
            'ajax':"{{ route('usuarios.dataUsuarioMail', ['usuarioId' => $usuario->id]) }}",
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
                //{data:'id'},
                {data:'mail'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 80},
            ]
        });
        
        var titleExportDocument = "{{ trans('labels.direccion') }}";
        $("#tableDireccionPersona").DataTable({
            'responsive': true,
            'bAutoWidth': false,
            'lengthChange': true,
            'autoWidth': false,
            //'ordering': false,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 50,
            'ajax':"{{ route('usuarios.dataUsuarioAddress', ['usuarioId' => $usuario->id]) }}",
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
                //{data:'id'},
                {data:'pais_nombre'},
                {data:'provincia'},
                {data:'ciudad'},
                {data:'direccion'},
                {data:'zip'},
                {data:'telefono'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 80},
            ]
        });

    });
</script>

@endSection