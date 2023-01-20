<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UsuarioSitio
 * 
 * @property int $id
 * @property int $usuario_id
 * @property int $sitio_id
 * @property bool|null $predeterminado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Sitio $sitio
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class UsuarioSitio extends Model
{
	use SoftDeletes;
	protected $table = 'usuario_sitio';

	protected $casts = [
		'usuario_id' => 'int',
		'sitio_id' => 'int',
		'predeterminado' => 'bool'
	];

	protected $fillable = [
		'usuario_id',
		'sitio_id',
		'predeterminado'
	];

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}
}
