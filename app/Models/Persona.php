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
 * Class Persona
 * 
 * @property int $id
 * @property string $nombres
 * @property string $apellidos
 * @property string|null $identificacion
 * @property int|null $tipo_identificacion_id
 * @property string|null $telefono
 * @property Carbon|null $fecha_nacimiento
 * @property string $selector
 * @property bool|null $notificar_por_mail
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property ItemCatalogo|null $item_catalogo
 * @property Collection|PersonaDireccion[] $persona_direccions
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Persona extends Model
{
	use SoftDeletes;
	protected $table = 'persona';

	protected $casts = [
		'tipo_identificacion_id' => 'int',
		'notificar_por_mail' => 'bool',
		'enabled' => 'bool'
	];

	protected $dates = [
		'fecha_nacimiento'
	];

	protected $fillable = [
		'nombres',
		'apellidos',
		'identificacion',
		'tipo_identificacion_id',
		'telefono',
		'fecha_nacimiento',
		'selector',
		'notificar_por_mail',
		'enabled'
	];

	public function item_catalogo()
	{
		return $this->belongsTo(ItemCatalogo::class, 'tipo_identificacion_id');
	}

	public function persona_direccions()
	{
		return $this->hasMany(PersonaDireccion::class);
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class);
	}
}
