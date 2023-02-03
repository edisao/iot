<?php

namespace App\Libraries;

use App\Helpers\Constants;
use App\Models\{Modulo, Funcionalidad, Usuario};
use App\Libraries\AuthUtil;
use Illuminate\Support\Facades\Log;
use File;

class Util
{
    protected $constants;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param  $controllador Nombre del controlador
     * @param  $tipoMetodo Tipo del metodo
     * @param  $ruta Nombre de la ruta
     * @param  $metodoControlador Nombre del Controlador
     */
    public function adminFunctionality($controllador, $tipoMetodo, $ruta, $metodoControlador)
    {
        $moduloId = 0;
        $funcionalidadId = 0;
        $codigoModulo = '';
        $showMenu = false;
        $registrarAcceso = false;
        if (!empty($controllador)) {
            switch ($controllador) {
                case 'FuncionalidadesController':
                    $codigoModulo = 'SEGURIDAD';
                    break;
                case 'CatalogosController':
                    $codigoModulo = 'CONFIGURACION';
                    break;
                case 'ItemCatalogosController':
                    $codigoModulo = 'CONFIGURACION';
                    break;
                case 'ModulosController':
                    $codigoModulo = 'SEGURIDAD';
                    break;
                case 'ParametrosController':
                    $codigoModulo = 'CONFIGURACION';
                    break;
                case 'RolesController':
                    $codigoModulo = 'SEGURIDAD';
                    break;
                case 'PerfilesController':
                    $codigoModulo = 'MI_PERFIL';
                    break;
                case 'NotificacionesController':
                    $codigoModulo = 'NOTIFICACIONES';
                    break;
                case 'UsuariosController':
                    $codigoModulo = 'USERS';
                    break;
                case 'PersonasController':
                    $codigoModulo = 'USERS';
                    break;
                case 'SitiosController':
                    $codigoModulo = 'SEGURIDAD';
                    break;
                case 'NotificacionesController':
                    $codigoModulo = 'NOTIFICACIONES';
                    break;
                case 'MatrizNotificacionesController':
                    $codigoModulo = 'NOTIFICACIONES';
                    break;
                case 'LibretasController':
                    $codigoModulo = 'MI_PERFIL';
                    break;
                case 'TareasController':
                    $codigoModulo = 'MI_PERFIL';
                    break;
                case 'ContenidosController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'SeccionesController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'ContenidoRecursosController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'GaleriasController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'GaleriaDetallesController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'MenusController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'SitioAlertasController':
                    $codigoModulo = 'ALERTAS';
                    break;
                case 'MenuItemsController':
                    $codigoModulo = 'CONTENIDOS';
                    break;
                case 'MailsController':
                    $codigoModulo = 'MENSAJERIA';
                    break;
                case 'CategoriaProductosController':
                    $codigoModulo = 'ECOMMERCE';
                    break;
                case 'MarcaProductosController':
                    $codigoModulo = 'ECOMMERCE';
                    break;
                case 'ProductosController':
                    $codigoModulo = 'ECOMMERCE';
                    break;
                case 'ProductoRecursosController':
                    $codigoModulo = 'ECOMMERCE';
                    break;
                case 'ProductoCategoriasController':
                    $codigoModulo = 'ECOMMERCE';
                    break;
                case 'PedidosController':
                    $codigoModulo = 'ECOMMERCE';
                    break;
                    /*case '': 
                    $codigoModulo = '';
                    break;*/
                default:
                    $codigoModulo = 'DASHBOARD';
            }

            if (!empty($codigoModulo)) {
                $module = Modulo::select('id')->where('codigo', $codigoModulo)->first();
                $moduloId = $module->id;

                $codigoFuncionalidad = str_replace('.', '_', $ruta);
                if ($metodoControlador == 'index')
                    $showMenu = true;
                if ($metodoControlador != 'data')
                    $registrarAcceso = true;
                $funcionalidad = Funcionalidad::select('id')->where('codigo', $codigoFuncionalidad)->first();
                if (!isset($funcionalidad->id)) {
                    $funcionalidad = new Funcionalidad();
                    $funcionalidad->modulo_id = $module->id;
                    $funcionalidad->codigo = $codigoFuncionalidad;
                    $funcionalidad->nombre = ucfirst(str_replace('.', ' ', $ruta));
                    $funcionalidad->nombre_mostrar = ucfirst(str_replace('.', ' ', $ruta));
                    $funcionalidad->descripcion = ucfirst(str_replace('.', ' ', $ruta));
                    $funcionalidad->orden = 1;
                    $funcionalidad->icono_css = null;
                    $funcionalidad->mostrar_en_menu = $showMenu;
                    $funcionalidad->numero_accesos = 0;
                    $funcionalidad->registrar_acceso = $registrarAcceso;
                    $funcionalidad->notificar_alerta = false;
                    $funcionalidad->validar_acceso = true;
                    $funcionalidad->accion = $tipoMetodo;
                    $funcionalidad->ruta = $ruta;
                    $funcionalidad->enabled = true;
                    $funcionalidad->save();
                    $funcionalidadId = $funcionalidad->id;
                } else {
                    $funcionalidadId = $funcionalidad->id;
                }
            }
        }

        return array(
            "moduloId" => $moduloId,
            "funcionalidadId" => $funcionalidadId
        );
    }

    public function getSelector($length = 25)
    {
        if (!isset($length) || intval($length) <= 8) {
            $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }

    function getIcoCssPreviewFile($nombreArchivo)
    {
        $cssIconoPreviewFile = '';
        $archivo_name = $nombreArchivo;
        $extensiones = explode(".", $archivo_name);

        // Archivo sin extencion
        if (count($extensiones) == 1)
            $extFile = "png";
        else {
            $num = count($extensiones) - 1;
            $extFile = $extensiones[$num];
        }

        switch ($extFile) {
            case 'doc':
                $cssIconoPreviewFile = 'fa fa-file-word-o';
                break;
            case 'docx':
                $cssIconoPreviewFile = 'fa fa-file-word-o';
                break;
            case 'xls':
                $cssIconoPreviewFile = 'fa fa-bar-chart-o';
                break;
            case 'xlsx':
                $cssIconoPreviewFile = 'fa fa-bar-chart-o';
                break;
            case 'pdf':
                $cssIconoPreviewFile = 'fa fa-file-pdf-o';
                break;
            case 'ppt':
                $cssIconoPreviewFile = 'fa fa-file-powerpoint-o';
                break;
            case 'pptx':
                $cssIconoPreviewFile = 'fa fa-file-powerpoint-o';
                break;
            case 'zip':
                $cssIconoPreviewFile = 'fa fa-file-zip-o';
                break;
            case 'rar':
                $cssIconoPreviewFile = 'fa fa-file-zip-o';
                break;
            case 'mp3':
                $cssIconoPreviewFile = 'fa fa-music';
                break;
            case 'wav':
                $cssIconoPreviewFile = 'fa fa-music';
                break;
            case 'txt':
                $cssIconoPreviewFile = 'fa fa-file-text-o';
                break;
            case 'avi':
                $cssIconoPreviewFile = 'fa fa-film';
                break;
            case 'mpg':
                $cssIconoPreviewFile = 'fa fa-film';
                break;
            case 'mpg4':
                $cssIconoPreviewFile = 'fa fa-film';
                break;
            default:
                $cssIconoPreviewFile = 'fa fa-file';
        }

        return $cssIconoPreviewFile;
    }

    function getUrl($path)
    {
        $url = "";
        if (!empty($path) && Storage::disk('public')->exists($path))
            $url = Storage::url($path);
        return $url;
    }

    // Path de los recursos del usuario
    function getCurrentBaseUserPath($source = '')
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();
        $userPath = '';
        $userSelector = $authUtil->getServiceContextValue($constants->contextSelector);
        $additionalSource = !empty($source) ? $source . '/' : '';
        $userPath = $constants->baseUserPath . $userSelector . '/' . $additionalSource;
        File::ensureDirectoryExists($userPath);
        return $userPath;
    }

    // Path de los recursos tipo Menu
    function getCurrentBaseMenuPath()
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();
        $menuPath = '';
        $sitioSelector = $authUtil->getServiceContextValue($constants->contextSitioSelector);
        $menuPath = $constants->baseMenuPath . $sitioSelector . '/';
        File::ensureDirectoryExists($menuPath);
        return $menuPath;
    }



    // Path de los recursos del sitio
    function getCurrentBaseSitioPath()
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();
        $userPath = '';
        $sitioSelector = $authUtil->getServiceContextValue($constants->contextSitioSelector);
        $userPath = $constants->baseSitioPath . $sitioSelector . '/';
        File::ensureDirectoryExists($userPath);
        return $userPath;
    }
}
