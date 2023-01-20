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
 * Class CategoriaProducto
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
 * @property Collection|ProductoCategorium[] $producto_categoria
 *
 * @package App\Models
 */
class CategoriaProducto extends Model
{
	use SoftDeletes;
	protected $table = 'categoria_producto';

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

	public static function getCategoriaProductos()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = CategoriaProducto::query()
			->select('categoria_producto.*')
			->where('categoria_producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->orderBy('categoria_producto.nombre', 'asc')
			->get();
		return $data;
	}

	public static function getCategoriaProductoById($id)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = CategoriaProducto::query()
			->select('categoria_producto.*')
			->where('categoria_producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('categoria_producto.id', $id)
			->orderBy('categoria_producto.nombre', 'asc')
			->first();
		return $data;
	}

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}

	public function producto_categoria()
	{
		return $this->hasMany(ProductoCategorium::class, 'categoria_id');
	}
}
