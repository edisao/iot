<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RolFuncionalidad
 * 
 * @property int $id
 * @property int $rol_id
 * @property int $funcionalidad_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Funcionalidad $funcionalidad
 * @property Rol $rol
 *
 * @package App\Models
 */
class RolFuncionalidad extends Model
{
	use SoftDeletes;
	protected $table = 'rol_funcionalidad';

	protected $casts = [
		'rol_id' => 'int',
		'funcionalidad_id' => 'int'
	];

	protected $fillable = [
		'rol_id',
		'funcionalidad_id'
	];

	public static function getFuncionalidadByRolIdFuncionalidadId($rolId, $funcionalidadId)
	{
		$sqlData = RolFuncionalidad::query()
			->select('rol_funcionalidad.id')
			->where('rol_funcionalidad.rol_id', $rolId)
			->where('rol_funcionalidad.funcionalidad_id', $funcionalidadId)
			->first();
		return $sqlData;
	}

	public static function getModuloByRolId($rolId)
	{
		$sqlData = RolFuncionalidad::query()
			->select('modulo.id', 'modulo.codigo', 'modulo.nombre', 'modulo.orden', 'modulo.icono_css')
			->join('funcionalidad', 'rol_funcionalidad.funcionalidad_id', '=', 'funcionalidad.id')
			->join('modulo', 'funcionalidad.modulo_id', '=', 'modulo.id')
			->where('rol_funcionalidad.rol_id', $rolId)
			->where('modulo.enabled', true)
			->orderBy('modulo.orden', 'asc')
			->distinct()
			->get();
		return $sqlData;
	}

	public function funcionalidad()
	{
		return $this->belongsTo(Funcionalidad::class);
	}

	public function rol()
	{
		return $this->belongsTo(Rol::class);
	}
}
