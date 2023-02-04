<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\Constants;
use App\Libraries\AuthUtil;

/**
 * Class Parametro
 * 
 * @property int $id
 * @property int $sitio_id
 * @property string|null $codigo
 * @property string|null $nombre
 * @property string|null $valor
 * @property string|null $descripcion
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Sitio $sitio
 *
 * @package App\Models
 */
class Parametro extends Model
{
	use SoftDeletes;
	protected $table = 'parametro';

	protected $casts = [
		'sitio_id' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'sitio_id',
		'codigo',
		'nombre',
		'valor',
		'descripcion',
		'enabled'
	];

	public static function getValueParametroByCode($parameterCode)
	{
		$response = 0;
		$data = Parametro::query()
			->select('id', 'codigo', 'nombre', 'valor', 'descripcion', 'enabled')
			->where('codigo', $parameterCode)
			->first();
		if (isset($data))
			$response = $data->valor;
		return $response;
	}

	public static function getParametroByCode($parameterCode)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();

		$data = Parametro::query()
			->select('id', 'codigo', 'nombre', 'valor', 'descripcion', 'enabled')
			->where('sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('codigo', $parameterCode)
			->first();
		return $data;
	}

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}
}
