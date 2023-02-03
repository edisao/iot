@extends('layouts.main')
@section('page_title', trans('msg.msgNuevoRegistro'))

@section('css_select2')
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2-bootstrap4.min.css') }}">
@endSection

@section('page_content')
    <!-- Content Page header -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.crearUsuario') .' - ' . $persona->nombres . ' ' . $persona->apellidos}}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('personas.index') }}">{{ trans('labels.personas') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('personas.show', $persona) }}">{{ $persona->nombres . ' ' . $persona->apellidos }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ trans('labels.crearUsuario') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    
                    <form role="form" name="FormRegistro" id="FormRegistro" action="{{ route('personas.storeUserPerson') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <h1>{{ trans('labels.usuarios') }}</h1>
                        <div class="form-group">
                            <label for="Username">{{ trans('labels.username') }}</label>
                            <input type="text" class="form-control" id="Username" name="Username" value="{{old('Username', $persona->mail_principal)}}" >
                            @error('Username')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Clave">{{ trans('labels.claveAcceso') }}</label>
                            <input type="text" class="form-control" id="Clave" name="Clave" value="{{old('Clave', $newPassword)}}" maxlength="30" autocomplete="off" placeholder=""  required>
                            @error('Clave')
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
                        <div class="hr-line-dashed"></div>
                        <div>
                            <input id="PersonaId" name="PersonaId" type="hidden" value="{{ $persona->id }}" />
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

@section('script')
<script>
    $(function() {
        $('.select2').select2({placeholder :'{{trans('labels.seleccioneItem')}}', allowClear: true});
        $('#FormRegistro').validate({
            rules: {
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