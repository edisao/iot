<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UsuarioRecurso
 * 
 * @property int $id
 * @property int $usuario_id
 * @property int $tipo_id
 * @property string|null $nombre
 * @property string|null $archivo
 * @property string|null $url
 * @property string|null $url_thum
 * @property string|null $url_thum_adicional
 * @property string|null $descripcion
 * @property bool|null $general
 * @property bool|null $visible
 * @property string|null $selector
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property ItemCatalogo $item_catalogo
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class UsuarioRecurso extends Model
{
	use SoftDeletes;
	protected $table = 'usuario_recurso';

	protected $casts = [
		'usuario_id' => 'int',
		'tipo_id' => 'int',
		'general' => 'bool',
		'visible' => 'bool',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'usuario_id',
		'tipo_id',
		'nombre',
		'archivo',
		'url',
		'url_thum',
		'url_thum_adicional',
		'descripcion',
		'general',
		'visible',
		'selector',
		'enabled'
	];

	public function item_catalogo()
	{
		return $this->belongsTo(ItemCatalogo::class, 'tipo_id');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}
}
