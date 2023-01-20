<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UsuarioRol
 * 
 * @property int $id
 * @property int $usuario_id
 * @property int $rol_id
 * @property bool|null $predeterminado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Rol $rol
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class UsuarioRol extends Model
{
	use SoftDeletes;
	protected $table = 'usuario_rol';

	protected $casts = [
		'usuario_id' => 'int',
		'rol_id' => 'int',
		'predeterminado' => 'bool'
	];

	protected $fillable = [
		'usuario_id',
		'rol_id',
		'predeterminado'
	];

	public function rol()
	{
		return $this->belongsTo(Rol::class);
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}
}
