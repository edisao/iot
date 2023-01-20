<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Constants;
use App\Libraries\AuthUtil;

/**
 * Class MarcaProducto
 * 
 * @property int $id
 * @property int $sitio_id
 * @property string|null $nombre
 * @property string|null $resumen
 * @property int|null $orden
 * @property string|null $imagen
 * @property string|null $url_imagen
 * @property string|null $url_imagen_thum
 * @property int|null $total_productos
 * @property string|null $slug
 * @property bool|null $enabled
 * @property string $selector
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Sitio $sitio
 * @property Collection|PedidoDetalle[] $pedido_detalles
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class MarcaProducto extends Model
{
	use SoftDeletes;
	protected $table = 'marca_producto';

	protected $casts = [
		'sitio_id' => 'int',
		'orden' => 'int',
		'total_productos' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'sitio_id',
		'nombre',
		'resumen',
		'orden',
		'imagen',
		'url_imagen',
		'url_imagen_thum',
		'total_productos',
		'slug',
		'enabled',
		'selector'
	];

	public static function getMarcaProductos()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = MarcaProducto::query()
			->select('marca_producto.*')
			->where('marca_producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->orderBy('marca_producto.nombre', 'asc')
			->get();
		return $data;
	}

	public static function getMarcaProductoById($id)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = MarcaProducto::query()
			->select('marca_producto.*')
			->where('marca_producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('marca_producto.id', $id)
			->orderBy('marca_producto.nombre', 'asc')
			->first();
		return $data;
	}

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}

	public function pedido_detalles()
	{
		return $this->hasMany(PedidoDetalle::class, 'marca_id');
	}

	public function productos()
	{
		return $this->hasMany(Producto::class, 'marca_id');
	}
}
