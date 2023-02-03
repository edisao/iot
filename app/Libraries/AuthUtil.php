<?php

namespace App\Libraries;

use App\Helpers\Constants;
use App\Models\{Modulo, Rol, Sitio, Usuario, UsuarioRol, UsuarioSitio, Funcionalidad};
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class AuthUtil
{
    protected $constants;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    public function getCountRolesByUserId($userId)
    {
        return UsuarioRol::where('usuario_id', $userId)->count();
    }

    public function getCountSitiosByUserId($userId)
    {
        return UsuarioSitio::where('usuario_id', $userId)->count();
    }

    public function regenerateServiceContext($username, $rolId = 0, $sitioId = 0)
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();
        $numeroLogins = 0;
        $userId = 0;
        $personId = 0;
        $rolPrincipalId = 0;
        $sitioPrincipalId = 0;
        $nombres = "";
        $apellidos = "";
        $mailPrincipal = "";
        $rolPrincipal = "";
        $sitioPrincipal = "";
        $imagenAvatar = '';
        $selector = '';

        try {

            $resultCode = 8;
            $resultDescription = "ERROR";
            $userIp = $_SERVER['REMOTE_ADDR'];
            $userLogin = Usuario::getUserByUsername($username);

            if (isset($userLogin)) {
                $userId = $userLogin->id;
                if ($userLogin->enabled) {
                    if ($userLogin->accede_panel_administracion) {
                        if (isset($userLogin->rol_principal_id)) {
                            if (isset($userLogin->sitio_principal_id)) {
                                $personId = $userLogin->persona_id;
                                $nombres = $userLogin->persona_nombres;
                                $apellidos = $userLogin->persona_apellidos;
                                $mailPrincipal = $userLogin->mail_principal;
                                //$imagenAvatar = $userLogin->imagen_avatar;
                                $selector = $userLogin->selector;
                                // Verifica si viene un Rol Id para obtener el nombre del Rol
                                // Ya que se trata de una cambio de Rol
                                if ($rolId > 0) {
                                    $objRol = Rol::find($rolId);
                                    $rolPrincipalId = $rolId;
                                    $rolPrincipal = $objRol->nombre;
                                } else {
                                    $rolPrincipalId = $authUtil->getServiceContextValue($constants->contextRolId);
                                    $rolPrincipal = $authUtil->getServiceContextValue($constants->contextRol);
                                }

                                // Verifica si viene un Sitio Id para obtener el nombre del Sitio
                                // Ya que se trata de una cambio de Sitio
                                if ($sitioId > 0) {
                                    $objSitio = Sitio::find($sitioId);
                                    $sitioPrincipalId = $sitioId;
                                    $sitioPrincipal = $objSitio->nombre;
                                    $sitioSelector = $objSitio->selector;
                                } else {
                                    //$sitioPrincipalId = $userLogin->sitio_principal_id;
                                    //$sitioPrincipal = $userLogin->sitio_nombre;
                                    $sitioPrincipalId = $authUtil->getServiceContextValue($constants->contextSitioId);
                                    $sitioPrincipal = $authUtil->getServiceContextValue($constants->contextSitio);
                                    $sitioSelector = $authUtil->getServiceContextValue($constants->contextSitioSelector);
                                }

                                // Usuario validado correctamente
                                // puede acceder al sitio
                                $resultCode = 0;
                                $resultDescription = trans('msg.msgUsuarioLoginOk');
                            } else {
                                $resultCode = 7;
                                $resultDescription = trans('msg.errUsuarioSinSitio');
                            }
                        } else {
                            $resultCode = 6;
                            $resultDescription = trans('msg.errUsuarioSinRol');
                        }
                    } else {
                        $resultCode = 4;
                        $resultDescription = trans('msg.errUsuarioSinAcceso');
                    }
                } else {
                    $resultCode = 3;
                    $resultDescription = trans('msg.errUsuarioInactivo');
                }
            } else {
                // Username no existe
                $resultCode = 1;
                $resultDescription = trans('msg.errUsuarioNoExiste');
            }
            //return $resultCode . ' ' . $resultDescription;
            if ($resultCode == 0) {
                $timeoutSession = (!empty(Config::get('microtess.authentication.timeout')) ? Config::get('microtess.authentication.timeout') : "90");
                $currentDate = Carbon::now();
                $expirationDate = Carbon::now()->addMinutes($timeoutSession);
                $serviceContext = array(
                    $this->constants->contextSessionId => (string) Str::uuid(),
                    $this->constants->contextUserId => $userId,
                    $this->constants->contextPersonId => $personId,
                    $this->constants->contextRolId => $rolPrincipalId,
                    $this->constants->contextSitioId => $sitioPrincipalId,
                    $this->constants->contextSitioSelector => $sitioSelector,
                    $this->constants->contextRol => $rolPrincipal,
                    //$this->constants->contextRol => (($rolId == 0) ? $rolPrincipal : $rolId),
                    $this->constants->contextSitio => $sitioPrincipal,
                    //$this->constants->contextSitio => (($sitioId == 0) ? $sitioPrincipal : $sitioId),
                    $this->constants->contextFirstname => $nombres,
                    $this->constants->contextLastname => $apellidos,
                    $this->constants->contextEmail => $mailPrincipal,
                    $this->constants->contextUsername => $username,
                    //$this->constants->contextAvatar => $imagenAvatar,
                    $this->constants->contextSelector => $selector,
                    $this->constants->contextFechaAcceso => $currentDate,
                    $this->constants->contextFechaExpiracion => $expirationDate,
                );
                session([$this->constants->servicecontextName => $serviceContext]);
                //return redirect()->route('dashboard.index');
            } else {
                $this->removeSession();
                // Genera la sesion con el mensaje de error al regenerar el Servicecontext
                session([$this->constants->sessionErrorLogin => $resultDescription]);
                //return redirect()->route('login');
            }
        } catch (Exception $ex) {
            Log::critical("Regenerate Servicecontext Exception: " . $ex->getMessage() . '---' . $ex);
            Toastr::error(trans('msg.errProcesarInformacion') . ': ' . $ex->getMessage(), trans('labels.usuarios'), $this->constants->notificationDefaultOptions);
        }
    }

    /*
        Elimina las sesiones creadas
    */
    public function removeSession()
    {
        $dto = new Constants();
        //$request->session()->forget('key');
        $session_items = [
            $dto->servicecontextName,                           // Sesion Servicecontext
            $dto->sessionErrorLogin,                            // Sesion de mensaje para Login
            $dto->nameNotificationProcess,                      // Sesion de notificaciones
            $dto->sessionActiveMenu,                            // Sesion de el menu activo
            $dto->sessionPendingTask,                           // Sesion de las tareas pendientes del usuario
            $dto->sessionActiveAlerts,                          // Sesion de las alertas activas en el sitio
            $dto->sessionSummaryMails,                          // Sesion del resumen de mails del usuario Login
            //$dto->recoveryDataUserSession                     // Sesion para hacer el recovery del usuario
        ];
        session()->forget($session_items);
    }

    public function getServiceContextValue($value)
    {
        $dataResponse = "";
        if (session()->has($this->constants->servicecontextName)) {
            $curretSessionVale = session()->get($this->constants->servicecontextName);
            switch ($value) {
                case $this->constants->contextSessionId:
                    $dataResponse = $curretSessionVale[$this->constants->contextSessionId];
                    break;
                case $this->constants->contextFirstname:
                    $dataResponse = $curretSessionVale[$this->constants->contextFirstname];
                    break;
                case $this->constants->contextLastname:
                    $dataResponse = $curretSessionVale[$this->constants->contextLastname];
                    break;
                case $this->constants->contextUsername:
                    $dataResponse = $curretSessionVale[$this->constants->contextUsername];
                    break;
                case $this->constants->contextEmail:
                    $dataResponse = $curretSessionVale[$this->constants->contextEmail];
                    break;
                case $this->constants->contextToken:
                    $dataResponse = $curretSessionVale[$this->constants->contextToken];
                    break;
                case $this->constants->contextUserId:
                    $dataResponse = $curretSessionVale[$this->constants->contextUserId];
                    break;
                case $this->constants->contextPersonId:
                    $dataResponse = $curretSessionVale[$this->constants->contextPersonId];
                    break;
                case $this->constants->contextSitioId:
                    $dataResponse = $curretSessionVale[$this->constants->contextSitioId];
                    break;
                case $this->constants->contextSitioSelector:
                    $dataResponse = $curretSessionVale[$this->constants->contextSitioSelector];
                    break;
                case $this->constants->contextRolId:
                    $dataResponse = $curretSessionVale[$this->constants->contextRolId];
                    break;
                case $this->constants->contextSitio:
                    $dataResponse = $curretSessionVale[$this->constants->contextSitio];
                    break;
                case $this->constants->contextRol:
                    $dataResponse = $curretSessionVale[$this->constants->contextRol];
                    break;

                case $this->constants->contextSelector:
                    $dataResponse = $curretSessionVale[$this->constants->contextSelector];
                    break;
                case $this->constants->contextFechaAcceso:
                    $dataResponse = $curretSessionVale[$this->constants->contextFechaAcceso];
                    break;
                case $this->constants->contextFechaExpiracion:
                    $dataResponse = $curretSessionVale[$this->constants->contextFechaExpiracion];
                    break;
                default:
                    $dataResponse = "";
            }
        }
        return $dataResponse;
    }

    public function validateUserLogin()
    {
        $response = false;
        if (session()->has($this->constants->servicecontextName)) {
            $curretSessionVale = session()->get($this->constants->servicecontextName);
            // fecha de caducidad
            $expirationdate = $curretSessionVale[$this->constants->contextFechaExpiracion];
            if ($expirationdate > Carbon::now())
                $response = true;
        }

        return $response;
    }

    public function getSitioInfoById($sitioId)
    {
        return Sitio::getSitioById($sitioId);
    }

    public function getFuncionalidad($ruta, $tipoMetodo)
    {
        $funcionalidad = Funcionalidad::query()
            ->select('funcionalidad.id', 'funcionalidad.modulo_id', 'funcionalidad.codigo', 'funcionalidad.mostrar_en_menu', 'funcionalidad.validar_acceso', 'funcionalidad.registrar_acceso', 'funcionalidad.enabled', 'modulo.codigo AS modulo_codigo')
            ->join('modulo', 'funcionalidad.modulo_id', '=', 'modulo.id')
            ->where('funcionalidad.ruta', $ruta)
            ->where('funcionalidad.accion', $tipoMetodo)
            //->where('funcionalidad.enabled', true)
            ->first();
        return $funcionalidad;
    }
}
