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
 * Class Modulo
 * 
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property int|null $orden
 * @property string|null $icono_css
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Funcionalidad[] $funcionalidads
 *
 * @package App\Models
 */
class Modulo extends Model
{
	use SoftDeletes;
	protected $table = 'modulo';

	protected $casts = [
		'orden' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'orden',
		'icono_css',
		'enabled'
	];

	public function funcionalidads()
	{
		return $this->hasMany(Funcionalidad::class);
	}
}
