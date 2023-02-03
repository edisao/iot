<?php

namespace App\Models;

use App\Models\{RolFuncionalidad, SitioComentario, SitioAlerta, Mail};
use App\Models\Ecommerce\{Producto, Pedido};
use App\Helpers\Constants;
use App\Libraries\AuthUtil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $modulo_id
 * @property string $codigo
 * @property string $nombre
 * @property string $nombre_mostrar
 * @property string $descripcion
 * @property int $orden
 * @property string $icono_css
 * @property boolean $mostrar_en_menu
 * @property int $numero_accesos
 * @property boolean $notificar_alerta
 * @property boolean $validar_acceso
 * @property string $accion
 * @property boolean $enabled
 * @property string $ruta
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Modulo $modulo
 * @property RolFuncionalidad[] $rolFuncionalidads
 */
class Funcionalidad extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'funcionalidad';

    /**
     * @var array
     */
    protected $fillable = ['modulo_id', 'codigo', 'nombre', 'nombre_mostrar', 'descripcion', 'orden', 'icono_css', 'mostrar_en_menu', 'numero_accesos', 'notificar_alerta', 'validar_acceso', 'accion', 'enabled', 'ruta'];

    public static function registrarAccesoFuncionalidad($funcionalidadId)
    {
        $data = Funcionalidad::Find($funcionalidadId);
        if (isset($data)) {
            $data->numero_accesos = $data->numero_accesos + 1;
            $data->save();
        }
    }

    public static function getFunctionalityRegisterByRolId($rolId)
    {
        $data = RolFuncionalidad::query()
            ->select('rol_funcionalidad.id', 'funcionalidad.modulo_id', 'funcionalidad.codigo', 'funcionalidad.nombre_mostrar', 'funcionalidad.ruta', 'modulo.nombre AS modulo_nombre')
            ->join('funcionalidad', 'rol_funcionalidad.funcionalidad_id', '=', 'funcionalidad.id')
            ->join('modulo', 'funcionalidad.modulo_id', '=', 'modulo.id')
            ->where('rol_funcionalidad.rol_id', $rolId)
            //->orderBy('modulo.nombre','asc')
            ->get();
        return $data;
    }

    public static function getFunctionalityAvailableByRolId($rolId)
    {
        $data = RolFuncionalidad::query()
            ->select('rol_funcionalidad.funcionalidad_id')
            ->where('rol_funcionalidad.rol_id', $rolId)
            ->get();

        $available = Funcionalidad::query()
            ->select('funcionalidad.id', 'funcionalidad.modulo_id', 'funcionalidad.codigo', 'funcionalidad.nombre_mostrar', 'funcionalidad.ruta', 'modulo.nombre AS modulo_nombre')
            ->join('modulo', 'funcionalidad.modulo_id', '=', 'modulo.id')
            ->where('funcionalidad.enabled', true)
            ->where('modulo.enabled', true)
            ->whereNotIn('funcionalidad.id', $data)
            ->get();
        return $available;
    }

    public static function getFunctionalityByModuleId($moduleId)
    {
        $sqlData = Funcionalidad::query()
            ->select('funcionalidad.id', 'funcionalidad.codigo', 'funcionalidad.nombre_mostrar', 'funcionalidad.orden', 'funcionalidad.ruta', 'funcionalidad.notificar_alerta', 'modulo.codigo AS modulo_codigo', 'modulo.nombre AS modulo_nombre')
            ->join('modulo', 'funcionalidad.modulo_id', '=', 'modulo.id')
            ->where('funcionalidad.modulo_id', $moduleId)
            ->where('funcionalidad.enabled', true)
            ->where('funcionalidad.mostrar_en_menu', true)
            ->orderBy('funcionalidad.orden', 'asc')
            ->get();
        return $sqlData;
    }

    public static function getFunctionalityNotificationAlert($functionalityCode)
    {
        $total = 0;
        $data = Funcionalidad::query()
            ->select('funcionalidad.*')
            ->where('funcionalidad.codigo', $functionalityCode)
            ->first();
        if (isset($data)) {
            switch ($data->codigo) {
                case ('sitioComentarios_index'):
                    $total = SitioComentario::getCountAvailableComentary();
                    break;
                case ('alertas_index'):
                    $total = SitioAlerta::getCountSitioAlertasDisponibles();
                    break;
                case ('mails_index'):
                    $total = Mail::countMailsRecibidos(); //
                    break;
                case ('mails_important'):
                    $total = Mail::countImportantMails(); //
                    break;
                case ('mails_draft'):
                    $total = Mail::countDraftMails(); //
                    break;
                default:
                    $total = 0;
            }
        }

        return $total;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modulo()
    {
        return $this->belongsTo('App\Models\Modulo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolFuncionalidads()
    {
        return $this->hasMany('App\Models\RolFuncionalidad');
    }
}
