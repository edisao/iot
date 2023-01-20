@extends('layouts.main')
@section('page_title', trans('msg.msgNuevoRegistro'))

@section('css_select2')
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2-bootstrap4.min.css') }}">
@endSection

@section('css_daterangepicker')
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}">
@endsection

@section('page_content')
    <!-- Content Page header -->
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
                    <strong>{{ trans('labels.nuevo') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    
                    <form role="form" name="FormRegistro" id="FormRegistro" action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="Nombres">{{ trans('labels.nombre') }}</label>
                            <input type="text" class="form-control" id="Nombres" name="Nombres" value="{{old('Nombres')}}" maxlength="50" autocomplete="off" placeholder="" required>
                            @error('Nombres')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                            
                        </div>
                        <div class="form-group">
                            <label for="Apellidos">{{ trans('labels.apellidos') }}</label>
                            <input type="text" class="form-control" id="Apellidos" name="Apellidos" value="{{old('Apellidos')}}" maxlength="200" autocomplete="off" placeholder="" required>
                            @error('Apellidos')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                            
                        </div>
                        <div class="form-group">
                            <label for="Identificacion">{{ trans('labels.identificacion') }}</label>
                            <input type="text" class="form-control" id="Identificacion" name="Identificacion" value="{{old('Identificacion')}}" maxlength="20" autocomplete="off" placeholder="" >
                            @error('Identificacion')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ trans('labels.fechaNacimiento') }}</label>
                            <input type="text" class="form-control" id="FechaNacimiento" name="FechaNacimiento" value="{{old('FechaNacimiento')}}" autocomplete="off" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="Email">{{ trans('labels.mail') }}</label>
                            <input type="text" class="form-control" id="Email" name="Email" value="{{old('Email')}}" maxlength="250" autocomplete="off" placeholder=""  required>
                            @error('Email')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Telefono">{{ trans('labels.telefono') }}</label>
                            <input type="text" class="form-control" id="Telefono" name="Telefono" value="{{old('Telefono')}}" maxlength="50" autocomplete="off" placeholder=""  required>
                            @error('Telefono')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="TelefonoAdicional">{{ trans('labels.telefonoAdicional') }}</label>
                            <input type="text" class="form-control" id="TelefonoAdicional" name="TelefonoAdicional" value="{{old('TelefonoAdicional')}}" maxlength="50" autocomplete="off" placeholder="" >
                            @error('TelefonoAdicional')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="InformacionAdicional">{{ trans('labels.informacionAdicional') }}</label>
                            <input type="text" class="form-control" id="InformacionAdicional" name="InformacionAdicional" value="{{old('InformacionAdicional')}}" autocomplete="off" placeholder="" >
                            @error('InformacionAdicional')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        <h1>{{ trans('labels.configuracion') }}</h1>
                        <div class="form-group">
                            <label>{{ trans('labels.rolPrincipal') }}</label>
                            <select class="form-control select2" id="Rol" name="Rol" style="width: 100%;">
                                <option selected disabled hidden value='-1'></option>
                                @foreach ($roles as $row)
                                    <option value="{{$row->id}}">{{$row->nombre}}</option>
                                @endforeach
                            </select>
                            @error('Rol')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ trans('labels.sitioPrincipal') }}</label>
                            <select class="form-control select2" id="Sitio" name="Sitio" style="width: 100%;">
                                <option selected disabled hidden value='-1'></option>
                                @foreach ($sitios as $row)
                                    <option value="{{$row->id}}">{{$row->nombre}}</option>
                                @endforeach
                            </select>
                            @error('Sitio')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h1>{{ trans('labels.usuarios') }}</h1>

                        <div class="form-group">
                            <label for="Username">{{ trans('labels.username') }}</label>
                            <input type="text" class="form-control" id="Username" name="Username" value="{{old('Username')}}" >
                            @error('Username')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Clave">{{ trans('labels.claveAcceso') }}</label>
                            <input type="text" class="form-control" id="Clave" name="Clave" value="{{old('Clave')}}" maxlength="30" autocomplete="off" placeholder=""  required>
                            @error('Clave')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="AccedePanelAdministracion" name="AccedePanelAdministracion" @if(old('AccedePanelAdministracion')) checked @endif>
                            <label class="form-check-label" for="AccedePanelAdministracion">{{ trans('labels.accedePanelAdministracion') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="SoloLectura" name="SoloLectura" @if(old('SoloLectura')) checked @endif>
                            <label class="form-check-label" for="SoloLectura">{{ trans('labels.soloLectura') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="SuperAdministrador" name="SuperAdministrador" @if(old('SuperAdministrador')) checked @endif>
                            <label class="form-check-label" for="SuperAdministrador">{{ trans('labels.administrador') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="Background" name="Background" @if(old('Background')) checked @endif>
                            <label class="form-check-label" for="Background">{{ trans('labels.usuarioBackground') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="NotificarPorMail" name="NotificarPorMail" @if(old('NotificarPorMail')) checked @endif>
                            <label class="form-check-label" for="NotificarPorMail">{{ trans('labels.notificarPorMail') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="NotificarPorMensaje" name="NotificarPorMensaje" @if(old('NotificarPorMensaje')) checked @endif>
                            <label class="form-check-label" for="NotificarPorMensaje">{{ trans('labels.notificarPorMensaje') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="NotificarCumpleanios" name="NotificarCumpleanios" @if(old('NotificarCumpleanios')) checked @endif>
                            <label class="form-check-label" for="NotificarCumpleanios">{{ trans('labels.notificarCumpleanios') }}</label>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div>
                            <button type="submit" class="btn btn-primary">{{ trans('labels.registrar') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
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

@section('script')
<script>
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

        $('#FormRegistro').validate({
            rules: {
                Nombres: {
                    required: true,
                },
                Apellidos: {
                    required: true,
                },
                Email: {
                    required: true,
                    email: true
                },
                Telefono: {
                    required: true,
                },
                Rol: {
                    required: true,
                },
                Sitio: {
                    required: true,
                },
                Username: {
                    required: true,
                },
                Clave: {
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
                Email: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Email']) }}",
                    email: "{{ trans('validation.email', [ 'attribute' => 'Mail']) }}",
                },
                Telefono: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Telefono']) }}",
                },
                Rol: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Rol']) }}",
                },
                Sitio: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Sitio']) }}",
                },
                Username: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Username']) }}",
                },
                Clave: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Clave']) }}",
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

    });
</script>

@endSection