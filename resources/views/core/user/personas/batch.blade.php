@extends('layouts.main')
@section('page_title', trans('msg.msgNuevoRegistro'))

@section('page_content')
    <!-- Content Page header -->
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
                    <strong>{{ trans('labels.nuevo') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    
                    <form role="form" name="FormRegistro" id="FormRegistro" action="{{ route('personas.batchStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        
                        <div class="form-group">
                            <label for="Formato">{{ trans('labels.formato') }}</label>
                            <div class="custom-file">
                                <span>Nombre;Apellidos;Identificacion;Fecha_nacimiento_MM/dd/yyyy;email;Telefono;Notificar_cumpleaños;</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Archivo">{{ trans('labels.archivo') }}</label>
                            <div class="custom-file">
                                <input id="Archivo" name="Archivo" class="form-control" type="file" name="files[]" accept="text/plain" value="{{old('Archivo')}}">
                                @error('Archivo')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
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

@section('script')
<script>
    $(function() {
        

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
                Email: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Email']) }}",
                },
                Telefono: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Telefono']) }}",
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