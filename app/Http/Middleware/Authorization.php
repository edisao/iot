<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\{Funcionalidad, RolFuncionalidad};
use App\Libraries\AuthUtil;
use App\Libraries\Util;
use App\Helpers\Constants;
use Carbon\Carbon;
use Toastr;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $util = new Util();
        $authUtil = new AuthUtil();
        $constants = new Constants();

        $validarAcceso = true;
        $registrarAcceso = false;
        $mostrarEnMenu = false;
        $funcionalidadId = 0;
        $funcionalidadCodigo = '';
        $moduloId = 0;
        $moduloCodigo = '';

        if (!$authUtil->validateUserLogin()) {
            $authUtil->removeSession();
            return redirect()->route('login');
            exit;
        }
        $rolId = $authUtil->getServiceContextValue($constants->contextRolId);
        $ipRequest = $_SERVER['REMOTE_ADDR'];

        $method = $request->getMethod(); // GET-POST-PUT
        $routeName = $request->route()->getName(); // ruta.index

        // Eliminar TEMPORAL: Registra los datos de la funcionalidad
        // Obtiene los datos del controlador 
        $currentAction = \Route::currentRouteAction();
        list($controlador, $metodoControlador) = explode('@', $currentAction);
        $controlador = preg_replace('/.*\\\/', '', $controlador);
        //dd($controlador.'---'.$method.'---'.$routeName.'---'.$metodoControlador);
        $adminFuncionalidad = $util->adminFunctionality($controlador, $method, $routeName, $metodoControlador);
        //dd($adminFuncionalidad);
        // End TEMPORAL

        // Valida si existe la funcionalidad
        $funcionalidad = $authUtil->getFuncionalidad($routeName, $method);
        if (!isset($funcionalidad)) {
            Toastr::error(trans('msg.errFuncionalidadNoExiste'), trans('labels.funcionalidades'), $constants->notificationDefaultOptions);
            return redirect()->route('dashboard.index');
            exit;
        } else {
            if (!$funcionalidad->enabled) {
                Toastr::error(trans('msg.errFuncionalidadDesactivada'), trans('labels.funcionalidades'), $constants->notificationDefaultOptions);
                return redirect()->route('dashboard.index');
                exit;
            }

            $validarAcceso = $funcionalidad->validar_acceso;
            $registrarAcceso = $funcionalidad->registrar_acceso;
            $funcionalidadId = $funcionalidad->id;
            $funcionalidadCodigo = $funcionalidad->codigo;
            $moduloId = $funcionalidad->modulo_id;
            $moduloCodigo = $funcionalidad->modulo_codigo;
            $mostrarEnMenu = $funcionalidad->mostrar_en_menu;
            if ($mostrarEnMenu && $funcionalidadCodigo != 'logs')  // La funcionalidad LOGS no se activa en el menú 
            {
                $activeMenu = array('modulo' => $moduloCodigo, 'funcionalidad' => $funcionalidadCodigo);
                session([$constants->sessionActiveMenu => $activeMenu]);
            }
        }

        // Valida si el usuario tiene acceso a la funcionalidad
        if ($validarAcceso) {
            $rolFuncObject = RolFuncionalidad::getFuncionalidadByRolIdFuncionalidadId($rolId, $funcionalidadId);
            if (!isset($rolFuncObject)) {
                Log::critical('Acceso no permitido del: RolId: ' . $rolId . ' a la FuncionalidadId: ' . $funcionalidadId);
                Toastr::error(trans('msg.errAccesoNoPermitido'), trans('labels.funcionalidades'), $constants->notificationDefaultOptions);
                return redirect()->route('dashboard.index');
                exit;
            }
        }

        // Registra el acceso a la funcionalidad
        if ($registrarAcceso) {
            Funcionalidad::registrarAccesoFuncionalidad($funcionalidadId);
        }

        return $next($request);
    }
}
