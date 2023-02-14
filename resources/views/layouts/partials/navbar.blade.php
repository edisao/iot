<?php 
    use App\Libraries\AuthUtil;
    use App\Models\{RolFuncionalidad, Funcionalidad};
    use App\Helpers\Constants;
    use App\Libraries\Util;

    $authUtil = new AuthUtil();
    $util = new Util();
    $constants = new Constants();

    $usuarioNombres = $authUtil->getServiceContextValue($constants->contextFirstname);
    $usuarioApellidos = $authUtil->getServiceContextValue($constants->contextLastname);
    $usuarioAvatar = $authUtil->getServiceContextValue($constants->contextAvatar);
    $rol = $authUtil->getServiceContextValue($constants->contextRol);
    $rolId = $authUtil->getServiceContextValue($constants->contextRolId);
    $userId = $authUtil->getServiceContextValue($constants->contextUserId);
    $countUserRoles = $authUtil->getCountRolesByUserId($userId);
    $countUserSitios = $authUtil->getCountSitiosByUserId($userId);
    $modulosMenu = RolFuncionalidad::getModuloByRolId($rolId);
    $activeModulo = '';
    $activeFuncionalidad = '';
    if (session()->has($constants->sessionActiveMenu)) {
        $curretActiveMenu = session()->get($constants->sessionActiveMenu);
        $activeModulo = $curretActiveMenu['modulo'];
        $activeFuncionalidad = $curretActiveMenu['funcionalidad'];
    }
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            <li class="nav-header">
                <div class="dropdown profile-element">
                                         
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">
                            <?php echo $usuarioNombres . ' ' . $usuarioApellidos; ?>
                        </span>
                        <span class="text-muted text-xs block">{{$rol}} <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">{{ trans('labels.salirSistema') }}</a></li>
                        <li class="dropdown-divider"></li>
                    </ul>
                </div>
                <div class="logo-element">
                    MT+
                </div>
            </li>
                @foreach ($modulosMenu as $modulo)
                <li class="{{ ($modulo->codigo == $activeModulo) ? "active" : "" }}">
                    <a href="#">
                        <i class="{{ $modulo->icono_css }}"></i> <span class="nav-label">{{ $modulo->nombre }}</span> <span class="fa arrow"></span>
                    </a>
                    <?php 
                        $funcMenu = Funcionalidad::getFunctionalityByModuleId($modulo->id)
                    ?>

                    <ul class="nav nav-second-level collapse">
                    @foreach ($funcMenu as $funcionalidad)
                    <?php
                        $alerta = '';
                        if($funcionalidad->notificar_alerta)
                        {
                            $total = Funcionalidad::getFunctionalityNotificationAlert($funcionalidad->codigo);
                            $alerta = ($total != '0') ? '<span class="label label-info float-right">' . $total . '</span>' : '';
                        }
                    ?>
                        <li class="{{ ($funcionalidad->codigo == $activeFuncionalidad) ? "active" : "" }}">
                            @if ($funcionalidad->codigo == 'logs')
                            <a href="{{ route($funcionalidad->ruta) }}" target="_blank" >{{ $funcionalidad->nombre_mostrar }}</a> 
                            @else
                            <a href="{{ route($funcionalidad->ruta) }}">{{ $funcionalidad->nombre_mostrar }} {!! $alerta !!}</a>
                            @endif
                        </li>
                    @endforeach
                    </ul>
                </li>
                @endforeach
        </ul>
    </div>
</nav>