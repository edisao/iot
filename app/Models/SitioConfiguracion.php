<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SitioConfiguracion
 * 
 * @property int $id
 * @property int $sitio_id
 * @property string $nombre
 * @property string $codigo_sitio
 * @property string|null $xml
 * @property string|null $url
 * @property string|null $user
 * @property string|null $password
 * @property string|null $selector
 * @property bool|null $enabled
 * @property bool $principal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Sitio $sitio
 *
 * @package App\Models
 */
class SitioConfiguracion extends Model
{
	use SoftDeletes;
	protected $table = 'sitio_configuracion';

	protected $casts = [
		'sitio_id' => 'int',
		'enabled' => 'bool',
		'principal' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'sitio_id',
		'nombre',
		'codigo_sitio',
		'xml',
		'url',
		'user',
		'password',
		'selector',
		'enabled',
		'principal'
	];

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}
}
