@extends('layouts.main')
@section('page_title', trans('labels.usuarios'))

@section('css_select2')
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2-bootstrap4.min.css') }}">
@endSection

@section('css_datatable')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}">
@endSection

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
                    <strong>{{$persona->persona_nombres . ' ' . $persona->persona_apellidos}}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <div class="wrapper wrapper-content">
                    
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <?php
                                            $imageEstado = "fa fa-times";
                                            $labelEnabled = "label-warning";
                                            $tooltipActivo = trans('labels.inactivo');
                                            if ($usuario->enabled) {
                                                $tooltipActivo = trans('labels.activo');
                                                $imageEstado = "fa fa-check";
                                                $labelEnabled = "label-primary";
                                            }
                                        ?>
                                        <span class="spacerMenu float-right m-l-xs" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.eliminar') }}"><a href="#" data-href="{{ route('usuarios.delete', $usuario) }}" data-toggle="modal" data-target="#modal-confirm-delete" data-placement="top" data-name="{{ $usuario->username }}" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.eliminar') }}</a></span> 
                                        <span class="spacerMenu float-right m-l-xs" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.editar') }}"><a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-default"><i class="fa fa-pencil"></i> {{ trans('labels.editar') }}</a></span>
                                        <span class="spacerMenu float-right m-l-xs" data-toggle="tooltip" data-placement="top" title="{{ $tooltipActivo }}"><a href="{{route('usuarios.enabled', $usuario)}}" class="btn btn-default {{ $labelEnabled }}"><i class="{{ $imageEstado }}"></i> {{ $tooltipActivo }}</a></span> 
                                        <h2>{{$persona->persona_nombres . ' ' . $persona->persona_apellidos}}</h2>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.estado') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"><span class="label {{ $labelEnabled }}">{{ $tooltipActivo }}</span></dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.numero') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ $usuario->id }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.id') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ $usuario->selector }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.username') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ $usuario->username }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.identificacion') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ $persona->identificacion }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.telefono') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ $persona->telefono }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.telefonoAdicional') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ $persona->telefono_adicional }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.mail') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ $persona->mail_principal }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.accedePanelAdministracion') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ ($usuario->accede_panel_administracion == true) ? trans('labels.si') : trans('labels.no') }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.usuarioValidado') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ ($usuario->usuario_validado == true) ? trans('labels.si') : trans('labels.no') }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.soloLectura') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ ($usuario->solo_lectura == true) ? trans('labels.si') : trans('labels.no') }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="col-lg-6" id="cluster_info">

                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.ultimaActualizacion') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ date('d-m-Y h:i:s', strtotime($usuario->updated_at)) }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.fechaCreacion') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ date('d-m-Y h:i:s', strtotime($usuario->created_at)) }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.rolPrincipal') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ $persona->rol_nombre }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.sitioPrincipal') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ $persona->sitio_nombre }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.notificarPorMail') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ ($persona->notificar_por_mail == true) ? trans('labels.si') : trans('labels.no') }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.notificarPorMensaje') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ ($persona->notificar_por_mensaje == true) ? trans('labels.si') : trans('labels.no') }}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.notificarCumpleanios') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1"> {{ ($persona->notificar_cumpleanos == true) ? trans('labels.si') : trans('labels.no') }}</dd>
                                        </div>
                                    </dl>
                                    @if ($persona->fecha_nacimiento != null)
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>{{ trans('labels.fechaNacimiento') }}:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">{{ date('d-m-Y', strtotime($persona->fecha_nacimiento)) }} ( <small>{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->diffForHumans() }}</small> )</dd>
                                        </div>
                                    </dl>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    
                                    <dl class="row mb-0">
                                        <div class="col-sm-2 text-sm-right">
                                            <dt>{{ trans('labels.informacionAdicional') }}:</dt>
                                        </div>
                                        <div class="col-sm-10 text-sm-left">
                                            <dd>
                                                {{ $usuario->detalle }}
                                            </dd>
                                        </div>
                                    </dl>
                                    
                                </div>
                            </div>
                            
                            <div class="row m-t-sm">
                                <div class="col-lg-12">
                                    <div class="panel blank-panel">
                                        
                                        <div class="wrapper wrapper-content">
                                            <div class="card card-primary card-outline card-outline-tabs">
                                                <div class="card-header p-0 border-bottom-0">
                                                    <ul class="nav nav-tabs" id="custom-tabs">
                                                        <li><a class="nav-link {{ empty($tabName) || $tabName == 'tab-1' ? 'active' : '' }}" href="#tab-1" data-toggle="tab">{{ trans('labels.roles') }}</a></li>
                                                        <li><a class="nav-link {{ !empty($tabName) && $tabName == 'tab-2' ? 'active' : '' }}" href="#tab-2" data-toggle="tab">{{ trans('labels.sitios') }}</a></li>
                                                        <li><a class="nav-link {{ !empty($tabName) && $tabName == 'tab-3' ? 'active' : '' }}" href="#tab-3" data-toggle="tab">{{ trans('labels.mail') }}</a></li>
                                                        <li><a class="nav-link {{ !empty($tabName) && $tabName == 'tab-4' ? 'active' : '' }}" href="#tab-4" data-toggle="tab">{{ trans('labels.direccion') }}</a></li>
                                                        <li><a class="nav-link {{ !empty($tabName) && $tabName == 'tab-5' ? 'active' : '' }}" href="#tab-5" data-toggle="tab">{{ trans('labels.accesos') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body">

                                            <div class="tab-content" id="custom-tabsContent">
                                                <div class="tab-pane {{ empty($tabName) || $tabName == 'tab-1' ? 'active' : '' }}" id="tab-1">
                                                    <div class="feed-activity-list">
                                                        <div class="feed-element">
                                                            
                                                            <form role="form" name="FormUsuarioRol" id="FormUsuarioRol" action="{{ route('usuarios.storeUsuarioRol') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>{{ trans('labels.roles') }}</label>
                                                                    <select class="form-control select2" id="Rol" name="Rol" style="width: 100%;">
                                                                        <option selected disabled hidden value='-1'></option>
                                                                        <?php foreach ($roles as $rol) : ?>
                                                                            <option value="<?= $rol->id ?>"><?= $rol->nombre ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    @error('Rol')
                                                                    <span class="small text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <input id="UsuarioRolId" name="UsuarioRolId" type="hidden" value="{{ $usuario->id }}" />
                                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.agregar') }}</button>
                                                                </div>
                                                            </form>

                                                            <div class="hr-line-dashed"></div>
                                                            <table id="tableRolUsuarios" class="table table-bordered table-striped" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ trans('labels.roles') }}</th>
                                                                        <th>{{ trans('labels.opciones') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane {{ !empty($tabName) && $tabName == 'tab-2' ? 'active' : '' }}" id="tab-2">
                                                    <div class="feed-activity-list">
                                                        <div class="feed-element">
                                                            
                                                            <form role="form" name="FormUsuarioSitio" id="FormUsuarioSitio" action="{{ route('usuarios.storeUsuarioSitio') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="form-group">
                                                                    <label>{{ trans('labels.sitios') }}</label>
                                                                    <select class="form-control select2" id="Sitio" name="Sitio" style="width: 100%;">
                                                                        <option selected disabled hidden value='-1'></option>
                                                                        <?php foreach ($sitios as $sitio) : ?>
                                                                            <option value="<?= $sitio->id ?>"><?= $sitio->nombre ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    @error('Sitio')
                                                                    <span class="small text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <input id="UsuarioSitioId" name="UsuarioSitioId" type="hidden" value="{{ $usuario->id }}" />
                                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.agregar') }}</button>
                                                                </div>
                                                            </form>

                                                            <div class="hr-line-dashed"></div>
                                                            <table id="tableSitioUsuarios" class="table table-bordered table-striped" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ trans('labels.sitios') }}</th>
                                                                        <th>{{ trans('labels.opciones') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane {{ !empty($tabName) && $tabName == 'tab-3' ? 'active' : '' }}" id="tab-3">

                                                    <form role="form" name="FormPersonaMail" id="FormPersonaMail" action="{{route('usuarios.updateUsuarioMail')}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('POST')
                                                        <div class="form-group">
                                                            <!-- data-role="tagsinput" -->
                                                            <label for="Mail">{{ trans('labels.mail') }}</label>
                                                            <input type="text" class="form-control" id="Mail" name="Mail" value="{{old('Mail')}}" placeholder="">
                                                            @error('Mail')
                                                            <span class="small text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <input id="UsuarioMailId" name="UsuarioMailId" type="hidden" value="{{ $usuario->id }}" />
                                                            <input id="PersonaMailId" name="PersonaMailId" type="hidden" value="{{ $persona->id }}" />
                                                            <button type="submit" class="btn btn-primary">{{ trans('labels.agregar') }}</button>
                                                        </div>
                                                    </form>
                                                    <div class="hr-line-dashed"></div>
                                                    <table id="tableMailPersona" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ trans('labels.mail') }}</th>
                                                                <th>{{ trans('labels.opciones') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane {{ !empty($tabName) && $tabName == 'tab-4' ? 'active' : '' }}" id="tab-4">

                                                    <form role="form" name="FormPersonaDireccion" id="FormPersonaDireccion" action="{{route('usuarios.updateUsuarioAddress')}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('POST')
                                                        <div class="form-group">
                                                            <label>{{ trans('labels.pais') }}</label>
                                                            <select class="form-control select2" id="Pais" name="Pais" style="width: 100%;">
                                                                <option selected disabled hidden value='-1'></option>
                                                                <?php foreach ($paises as $pais) : ?>
                                                                    <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <span class="small text-danger"><?= session('errors.Pais') ?></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Provincia">{{ trans('labels.provincia') }}</label>
                                                            <input type="text" class="form-control" id="Provincia" name="Provincia" value="{{old('Provincia')}}" placeholder="">
                                                            @error('Provincia')
                                                            <span class="small text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Ciudad">{{ trans('labels.ciudad') }}</label>
                                                            <input type="text" class="form-control" id="Ciudad" name="Ciudad" value="{{old('Ciudad')}}" placeholder="">
                                                            @error('Ciudad')
                                                            <span class="small text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Direccion">{{ trans('labels.direccion') }}</label>
                                                            <input type="text" class="form-control" id="Direccion" name="Direccion" value="{{old('Direccion')}}" placeholder="">
                                                            @error('Direccion')
                                                            <span class="small text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Zip">{{ trans('labels.zipCode') }}</label>
                                                            <input type="text" class="form-control" id="Zip" name="Zip" value="{{old('Zip')}}" placeholder="">
                                                            @error('Zip')
                                                            <span class="small text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="TelefonoDireccion">{{ trans('labels.telefono') }}</label>
                                                            <input type="text" class="form-control" id="TelefonoDireccion" name="TelefonoDireccion" value="{{old('TelefonoDireccion')}}" placeholder="">
                                                            @error('TelefonoDireccion')
                                                            <span class="small text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <input id="UsuarioDireccionId" name="UsuarioDireccionId" type="hidden" value="{{ $usuario->id }}" />
                                                            <input id="PersonaDirecionId" name="PersonaDirecionId" type="hidden" value="{{ $persona->id }}" />
                                                            <button type="submit" class="btn btn-primary">{{ trans('labels.agregar') }}</button>
                                                        </div>
                                                    </form>
                                                    <div class="hr-line-dashed"></div>
                                                    <table id="tableDireccionPersona" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ trans('labels.pais') }}</th>
                                                                <th>{{ trans('labels.provincia') }}</th>
                                                                <th>{{ trans('labels.ciudad') }}</th>
                                                                <th>{{ trans('labels.direccion') }}</th>
                                                                <th>{{ trans('labels.zipCode') }}</th>
                                                                <th>{{ trans('labels.telefono') }}</th>
                                                                <th>{{ trans('labels.opciones') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane {{ !empty($tabName) && $tabName == 'tab-5' ? 'active' : '' }}" id="tab-5">
                                                    <div class="feed-activity-list">
                                                        <div class="feed-element">
                                                            
                                                            <form role="form" name="FormUsuarioClaveAcceso" id="FormUsuarioClaveAcceso" action="{{ route('usuarios.updateAccesoUsuario') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')

                                                                <div class="form-group">
                                                                    <label for="Username">{{ trans('labels.username') }}</label>
                                                                    <input type="text" class="form-control" id="Username" name="Username" value="{{ $usuario->username }}" readonly>
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

                                                                <div class="form-group">
                                                                    <label for="ConfirmarClave">{{ trans('labels.claveAcceso') }}</label>
                                                                    <input type="text" class="form-control" id="ConfirmarClave" name="ConfirmarClave" value="{{old('ConfirmarClave')}}" maxlength="30" autocomplete="off" placeholder=""  required>
                                                                    @error('ConfirmarClave')
                                                                    <span class="small text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>

                                                                <div>
                                                                    <input id="UsuarioAccesoId" name="UsuarioAccesoId" type="hidden" value="{{ $usuario->id }}" />
                                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.agregar') }}</button>
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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.delete-confirm')

@endsection

@section('js_select2')
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
@endSection

@section('js_validation')
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/additional-methods.min.js') }}"></script>
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

        $('#FormUsuarioRol').validate({
            rules: {
                Rol: {
                    required: true,
                }
            },
            messages: {
                Rol: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Rol']) }}",
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

        var titleExportDocument = "{{ trans('labels.roles') }}";
        $("#tableRolUsuarios").DataTable({
            'responsive': true,
            'bAutoWidth': false,
            'lengthChange': true,
            'autoWidth': false,
            //'ordering': false,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 50,
            ajax:({
                url:"{{ route('usuarios.dataUsuarioRol') }}",
                data: {usuarioId:{{$usuario->id}},  _token: @json(csrf_token())},
            }),
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
                {data:'rol_nombre'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 80},
            ]
        });

        $('#FormUsuarioSitio').validate({
            rules: {
                Sitio: {
                    required: true,
                }
            },
            messages: {
                Sitio: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Sitio']) }}",
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

        var titleExportDocument = "{{ trans('labels.sitios') }}";
        $("#tableSitioUsuarios").DataTable({
            'responsive': true,
            'bAutoWidth': false,
            'lengthChange': true,
            'autoWidth': false,
            //'ordering': false,
            'order': [[ 0, 'desc' ]],
            dom: '<"html5buttons"B>lTfgitp',
            'lengthMenu': [10, 50, 100, 200, 1000, 2000, 5000],
            'pageLength': 50,
            ajax:({
                url:"{{ route('usuarios.dataUsuarioSitio') }}",
                data: {usuarioId:{{$usuario->id}},  _token: @json(csrf_token())},
            }),
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
                {data:'sitio_nombre'},
                {data:'opc', name: 'action', orderable:false, searchable:false, className: 'text-right', width: 80},
            ]
        });

        $('#FormUsuarioClaveAcceso').validate({
            rules: {
                Clave: {
                    required: true,
                    minlength: 5
                },
                ConfirmarClave: {
                    equalTo: "#Clave"
                }
            },
            messages: {
                Clave: {
                    required: "{{ trans('validation.required', [ 'attribute' => 'Clave']) }}",
                    minlength: "{{ trans('validation.min.numeric', [ 'attribute' => 'Clave', 'min' => '5']) }}"
                },
                ConfirmarClave: {
                    equalTo: "{{ trans('validation.password', [ 'attribute' => 'Clave']) }}",
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