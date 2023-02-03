<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Rol
 * 
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property bool|null $agrupa_funcionalidad
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Funcionalidad[] $funcionalidads
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Rol extends Model
{
	use SoftDeletes;
	protected $table = 'rol';

	protected $casts = [
		'agrupa_funcionalidad' => 'bool',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'descripcion',
		'agrupa_funcionalidad',
		'enabled'
	];

	public function funcionalidads()
	{
		return $this->belongsToMany(Funcionalidad::class, 'rol_funcionalidad')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function usuarios()
	{
		return $this->belongsToMany(Usuario::class, 'usuario_rol')
					->withPivot('id', 'predeterminado', 'deleted_at')
					->withTimestamps();
	}
}
