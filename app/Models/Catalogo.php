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
 * Class Catalogo
 * 
 * @property int $id
 * @property int $sitio_id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Sitio $sitio
 * @property Collection|ItemCatalogo[] $item_catalogos
 *
 * @package App\Models
 */
class Catalogo extends Model
{
	use SoftDeletes;
	protected $table = 'catalogo';

	protected $casts = [
		'sitio_id' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'sitio_id',
		'codigo',
		'nombre',
		'descripcion',
		'enabled'
	];

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}

	public function item_catalogos()
	{
		return $this->hasMany(ItemCatalogo::class);
	}
}
