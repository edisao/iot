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
 * Class Sitio
 * 
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string $selector
 * @property string $identificacion
 * @property string|null $resumen
 * @property string|null $descripcion
 * @property string|null $telefono_movil
 * @property string $mail
 * @property string|null $direccion
 * @property string|null $version
 * @property string|null $horario_atencion
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Catalogo[] $catalogos
 * @property Collection|CategoriaProducto[] $categoria_productos
 * @property Collection|MarcaProducto[] $marca_productos
 * @property Collection|Parametro[] $parametros
 * @property Collection|Pedido[] $pedidos
 * @property Collection|Producto[] $productos
 * @property Collection|SitioConfiguracion[] $sitio_configuracions
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Sitio extends Model
{
	use SoftDeletes;
	protected $table = 'sitio';

	protected $casts = [
		'enabled' => 'bool'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'selector',
		'identificacion',
		'resumen',
		'descripcion',
		'telefono_movil',
		'mail',
		'direccion',
		'version',
		'horario_atencion',
		'enabled'
	];

	public static function getSitioById($sitioId)
	{
		$data = Sitio::query()
			->select('sitio.*')
			->where('id', $sitioId)
			->first();
		return $data;
	}

	public function catalogos()
	{
		return $this->hasMany(Catalogo::class);
	}

	public function categoria_productos()
	{
		return $this->hasMany(CategoriaProducto::class);
	}

	public function marca_productos()
	{
		return $this->hasMany(MarcaProducto::class);
	}

	public function parametros()
	{
		return $this->hasMany(Parametro::class);
	}

	public function pedidos()
	{
		return $this->hasMany(Pedido::class);
	}

	public function productos()
	{
		return $this->hasMany(Producto::class);
	}


	public function sitio_configuracions()
	{
		return $this->hasMany(SitioConfiguracion::class);
	}

	public function usuarios()
	{
		return $this->belongsToMany(Usuario::class, 'usuario_sitio')
			->withPivot('id', 'predeterminado', 'deleted_at')
			->withTimestamps();
	}
}
