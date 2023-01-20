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
 * Class Pedido
 * 
 * @property int $id
 * @property int $sitio_id
 * @property int $usuario_id
 * @property int $estado_id
 * @property int|null $total_productos
 * @property Carbon|null $fecha_inicia_pedido
 * @property Carbon|null $fecha_fin_pedido
 * @property float|null $monto_total
 * @property string|null $observacion_cliente
 * @property string|null $informacion_adicional
 * @property string $selector
 * @property bool|null $enabled
 * @property bool|null $closed
 * @property Carbon|null $closed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property ItemCatalogo $item_catalogo
 * @property Sitio $sitio
 * @property Usuario $usuario
 * @property Collection|PedidoDetalle[] $pedido_detalles
 *
 * @package App\Models
 */
class Pedido extends Model
{
	use SoftDeletes;
	protected $table = 'pedido';

	protected $casts = [
		'sitio_id' => 'int',
		'usuario_id' => 'int',
		'estado_id' => 'int',
		'total_productos' => 'int',
		'monto_total' => 'float',
		'enabled' => 'bool',
		'closed' => 'bool'
	];

	protected $dates = [
		'fecha_inicia_pedido',
		'fecha_fin_pedido',
		'closed_at'
	];

	protected $fillable = [
		'sitio_id',
		'usuario_id',
		'estado_id',
		'total_productos',
		'fecha_inicia_pedido',
		'fecha_fin_pedido',
		'monto_total',
		'observacion_cliente',
		'informacion_adicional',
		'selector',
		'enabled',
		'closed',
		'closed_at'
	];

	public function item_catalogo()
	{
		return $this->belongsTo(ItemCatalogo::class, 'estado_id');
	}

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function pedido_detalles()
	{
		return $this->hasMany(PedidoDetalle::class);
	}
}
