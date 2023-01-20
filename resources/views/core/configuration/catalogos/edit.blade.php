@extends('layouts.main')
@section('page_title', trans('msg.msgEditarInformacion') )

@section('page_content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.catalogos') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/catalogos/">{{ trans('labels.catalogos') }}</a>
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
                    
                    <form role="form" name="FormRegistro" id="FormRegistro" action="{{route('catalogos.update',$catalogo)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="Nombre">{{ trans('labels.nombre') }}</label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre" value="{{old('Nombre', $catalogo->nombre )}}" maxlength="50" autocomplete="off" placeholder="" required>
                            @error('Nombre')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                            
                        </div>
                        <div class="form-group">
                            <label for="Codigo">{{ trans('labels.codigo') }}</label>
                            <input type="text" class="form-control" id="Codigo" name="Codigo" value="{{old('Codigo', $catalogo->codigo)}}" maxlength="30" autocomplete="off" placeholder=""  required>
                            @error('Codigo')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">{{ trans('labels.descripcion') }}</label>
                            <input type="text" class="form-control" id="Descripcion" name="Descripcion" value="{{old('Descripcion', $catalogo->descripcion)}}" maxlength="200" autocomplete="off" placeholder="" >
                            @error('Descripcion')
                            <span class="small text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary">{{ trans('labels.actualizar') }}</button>
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