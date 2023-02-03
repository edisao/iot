@extends('layouts.main')
@section('page_title', trans('msg.msgEditarInformacion') )

@section('css_daterangepicker')
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}">
@endsection

@section('page_content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.personas') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/personas/">{{ trans('labels.personas') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ trans('labels.editar') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    
                    <form role="form" name="FormRegistro" id="FormRegistro" action="{{route('personas.update',$persona)}}" method="POST" enctype="multipart/form-data">
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
                            <label for="Email">{{ trans('labels.mail') }}</label>
                            <input type="text" class="form-control" id="Email" name="Email" value="{{old('Email', $persona->mail_principal )}}" maxlength="250" autocomplete="off" placeholder=""  required>
                            @error('Email')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
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
                            <input type="text" class="form-control" id="InformacionAdicional" name="InformacionAdicional" value="{{old('InformacionAdicional', $persona->informacion_adicional )}}" autocomplete="off" placeholder="" >
                            @error('InformacionAdicional')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
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
@endsection

@section('js_daterangepicker')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}" charset="UTF-8"></script>
@endSection

@section('js_validation')
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/additional-methods.min.js') }}"></script>
@endSection

@section('script')
<script>
    $(function() {
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
                Nombre: {
                    required: true,
                },
                Codigo: {
                    required: true,
                }
            },
            messages: {
                Nombre: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Nombre']) }}",
                },
                Codigo: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Codigo']) }}",
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