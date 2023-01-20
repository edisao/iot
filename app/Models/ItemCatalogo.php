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
 * Class ItemCatalogo
 * 
 * @property int $id
 * @property int $catalogo_id
 * @property int|null $item_padre_id
 * @property string|null $codigo
 * @property string|null $nombre
 * @property string|null $valor
 * @property string|null $descripcion
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Catalogo $catalogo
 * @property ItemCatalogo|null $item_catalogo
 * @property Collection|ItemCatalogo[] $item_catalogos
 * @property Collection|Pedido[] $pedidos
 * @property Collection|PedidoDetalle[] $pedido_detalles
 * @property Collection|Persona[] $personas
 * @property Collection|PersonaDireccion[] $persona_direccions
 * @property Collection|Producto[] $productos
 * @property Collection|ProductoRecurso[] $producto_recursos
 * @property Collection|UsuarioRecurso[] $usuario_recursos
 *
 * @package App\Models
 */
class ItemCatalogo extends Model
{
	use SoftDeletes;
	protected $table = 'item_catalogo';

	protected $casts = [
		'catalogo_id' => 'int',
		'item_padre_id' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'catalogo_id',
		'item_padre_id',
		'codigo',
		'nombre',
		'valor',
		'descripcion',
		'enabled'
	];

	public static function getItemCatalogoIdByCatalogoCodeItemCode($codigoCatalogo, $codigoItemCatalogo)
	{

		$response = 0;
		$data = ItemCatalogo::query()
			->select('item_catalogo.id')
			->join('catalogo', 'item_catalogo.catalogo_id', '=', 'catalogo.id')
			//->where('catalogo.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('item_catalogo.codigo', $codigoItemCatalogo)
			->where('catalogo.codigo', $codigoCatalogo)
			//->where('item_catalogo.enabled', true)
			->first();
		if (isset($data))
			$response = $data->id;
		return $response;
	}

	public static function getItemCatalogosByCatalogoCode($codigoCatalogo)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();

		$data = ItemCatalogo::query()
			->select('item_catalogo.id', 'item_catalogo.codigo', 'item_catalogo.nombre', 'item_catalogo.valor')
			->join('catalogo', 'item_catalogo.catalogo_id', '=', 'catalogo.id')
			->where('catalogo.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('item_catalogo.enabled', true)
			->where('catalogo.codigo', $codigoCatalogo)
			->get();
		return $data;
	}

	public function catalogo()
	{
		return $this->belongsTo(Catalogo::class);
	}

	public function item_catalogo()
	{
		return $this->belongsTo(ItemCatalogo::class, 'item_padre_id');
	}

	public function item_catalogos()
	{
		return $this->hasMany(ItemCatalogo::class, 'item_padre_id');
	}

	public function pedidos()
	{
		return $this->hasMany(Pedido::class, 'estado_id');
	}

	public function pedido_detalles()
	{
		return $this->hasMany(PedidoDetalle::class, 'estado_id');
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'tipo_identificacion_id');
	}

	public function persona_direccions()
	{
		return $this->hasMany(PersonaDireccion::class, 'pais_id');
	}

	public function productos()
	{
		return $this->hasMany(Producto::class, 'unidad_peso_id');
	}

	public function producto_recursos()
	{
		return $this->hasMany(ProductoRecurso::class, 'tipo_id');
	}

	public function usuario_recursos()
	{
		return $this->hasMany(UsuarioRecurso::class, 'tipo_id');
	}
}
