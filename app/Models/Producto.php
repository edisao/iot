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
use App\Libraries\UtilEcommerce;
use URL;

/**
 * Class Producto
 * 
 * @property int $id
 * @property int $sitio_id
 * @property string|null $sku
 * @property string|null $codigo
 * @property string|null $nombre
 * @property string|null $nombre_alterno
 * @property string|null $slug
 * @property string|null $serie
 * @property int|null $marca_id
 * @property int|null $categoria_principal_id
 * @property string|null $resumen
 * @property string|null $detalle
 * @property string|null $imagen_portada
 * @property int|null $stock
 * @property string|null $url_informacion_adicional
 * @property int|null $unidad_medida_id
 * @property float|null $longitud
 * @property float|null $ancho
 * @property float|null $alto
 * @property int|null $unidad_peso_id
 * @property float|null $peso
 * @property int|null $unidades_caja
 * @property float|null $valoracion_general
 * @property bool|null $registra_comentarios
 * @property bool|null $mostrar_slider
 * @property int|null $orden
 * @property int|null $orden_adicional
 * @property string|null $link
 * @property string|null $link_corto
 * @property bool|null $en_oferta
 * @property float|null $precio_costo
 * @property bool $mostrar_precio
 * @property float|null $pvp
 * @property bool|null $incluye_impuestos
 * @property bool|null $mostrar_pvp_anterior
 * @property float|null $pvp_anterior
 * @property int|null $orden_slider
 * @property string $selector
 * @property bool|null $enabled
 * @property bool|null $published
 * @property Carbon|null $published_at
 * @property bool|null $recomendado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property MarcaProducto|null $marca_producto
 * @property Sitio $sitio
 * @property ItemCatalogo|null $item_catalogo
 * @property Collection|PedidoDetalle[] $pedido_detalles
 * @property Collection|ProductoCategorium[] $producto_categoria
 * @property Collection|ProductoRecurso[] $producto_recursos
 * @property Collection|ProductoRelacion[] $producto_relacions
 *
 * @package App\Models
 */
class Producto extends Model
{
	use SoftDeletes;
	protected $table = 'producto';

	protected $casts = [
		'sitio_id' => 'int',
		'marca_id' => 'int',
		'categoria_principal_id' => 'int',
		'stock' => 'int',
		'unidad_medida_id' => 'int',
		'longitud' => 'float',
		'ancho' => 'float',
		'alto' => 'float',
		'unidad_peso_id' => 'int',
		'peso' => 'float',
		'unidades_caja' => 'int',
		'valoracion_general' => 'float',
		'registra_comentarios' => 'bool',
		'mostrar_slider' => 'bool',
		'orden' => 'int',
		'orden_adicional' => 'int',
		'en_oferta' => 'bool',
		'precio_costo' => 'float',
		'mostrar_precio' => 'bool',
		'pvp' => 'float',
		'incluye_impuestos' => 'bool',
		'mostrar_pvp_anterior' => 'bool',
		'pvp_anterior' => 'float',
		'orden_slider' => 'int',
		'enabled' => 'bool',
		'published' => 'bool',
		'recomendado' => 'bool'
	];

	protected $dates = [
		'published_at'
	];

	protected $fillable = [
		'sitio_id',
		'sku',
		'codigo',
		'nombre',
		'nombre_alterno',
		'slug',
		'serie',
		'marca_id',
		'categoria_principal_id',
		'resumen',
		'detalle',
		'imagen_portada',
		'stock',
		'url_informacion_adicional',
		'unidad_medida_id',
		'longitud',
		'ancho',
		'alto',
		'unidad_peso_id',
		'peso',
		'unidades_caja',
		'valoracion_general',
		'registra_comentarios',
		'mostrar_slider',
		'orden',
		'orden_adicional',
		'link',
		'link_corto',
		'en_oferta',
		'precio_costo',
		'mostrar_precio',
		'pvp',
		'incluye_impuestos',
		'mostrar_pvp_anterior',
		'pvp_anterior',
		'orden_slider',
		'selector',
		'enabled',
		'published',
		'published_at',
		'recomendado'
	];

	public static function getOrderProductosOfert()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();

		$records = Producto::query()
			->select(
				'producto.id',
				'producto.sku',
				'producto.codigo',
				'producto.nombre',
				'producto.serie',
				'producto.resumen',
				'producto.imagen_portada',
				'producto.published',
				'producto.en_oferta',
				'producto.mostrar_precio',
				'producto.pvp',
				'producto.mostrar_slider',
				'producto.selector',
				'marca_producto.nombre AS marca_nombre'
			)
			->where('producto.published', true)
			->where('producto.en_oferta', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->orderBy('producto.orden', 'asc')
			->get();

		return $records;
	}

	public static function getOrderProductosSlider()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();

		$records = Producto::query()
			->select(
				'producto.id',
				'producto.sku',
				'producto.codigo',
				'producto.nombre',
				'producto.serie',
				'producto.resumen',
				'producto.imagen_portada',
				'producto.published',
				'producto.en_oferta',
				'producto.mostrar_precio',
				'producto.pvp',
				'producto.mostrar_slider',
				'producto.selector',
				'marca_producto.nombre AS marca_nombre'
			)
			->where('producto.published', true)
			->where('producto.mostrar_slider', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->orderBy('producto.orden_slider', 'asc')
			->get();

		return $records;
	}

	public static function getProductosRelacionadosByProductoId($productoId)
	{
		$records = ProductoRelacion::query()
			->select('producto_relacion.id', 'RELACION.id AS producto_id', 'RELACION.nombre AS producto_nombre')
			->join('producto AS RELACION', 'producto_relacion.relacion_producto_id', '=', 'RELACION.id')
			->where('producto_relacion.producto_id', $productoId)
			->orderBy('RELACION.nombre', 'asc')
			->get();
		return $records;
	}

	public static function getProductosDisponiblesRelacionadosByProductoId($productoId)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();

		$data = ProductoRelacion::query()
			->select('relacion_producto_id')
			->where('producto_id', $productoId)
			->get();

		$records = Producto::query()
			->select('producto.id', 'producto.nombre')
			->where('producto.published', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.id', '!=', $productoId) // Excluye el producto padre
			->whereNotIn('id', $data)
			->get();
		return $records;
	}

	public static function getMarcasDisponibles()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = MarcaProducto::query()
			->select('marca_producto.id', 'marca_producto.nombre')
			->where('marca_producto.enabled', true)
			->where('marca_producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->orderBy('marca_producto.nombre', 'asc')
			->get();
		return $data;
	}

	public static function getCategoriasDisponibles($productoId)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();

		$data = ProductoCategoria::query()
			->select('categoria_id')
			->where('producto_id', $productoId)
			->get();

		$available = CategoriaProducto::query()
			->select('id', 'nombre')
			->where('enabled', true)
			->where('sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->whereNotIn('id', $data)
			->get();
		return $available;
	}

	public static function countBorradorProducts()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$mail = Producto::query()
			->select('producto.*')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.published', false)
			->count();
		return $mail;
	}

	public static function countOfertaProducts()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$mail = Producto::query()
			->select('producto.*')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.published', true)
			->where('producto.en_oferta', true)
			->count();
		return $mail;
	}

	public static function countSliderProducts()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$mail = Producto::query()
			->select('producto.*')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.published', true)
			->where('producto.mostrar_slider', true)
			->count();
		return $mail;
	}

	public static function countPublicatedProducts()
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$mail = Producto::query()
			->select('producto.*')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.published', true)
			->count();
		return $mail;
	}

	public static function getProductosSlider($draw, $start, $rowperpage, $columnIndex_arr, $columnName_arr, $order_arr, $search_arr)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$utilEcommerce = new UtilEcommerce();

		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value

		// Total records
		$totalRecords = Producto::select('count(*) as allcount')
			->where('producto.published', true)
			->where('producto.mostrar_slider', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->count();

		$totalRecordswithFilter = Producto::select('count(*) as allcount')
			->where('producto.published', true)
			->where('producto.mostrar_slider', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->count();

		// Fetch records
		//$records = Producto::orderBy($columnName,$columnSortOrder)
		$records = Producto::orderBy('producto.orden_slider', 'asc')
			->where('producto.published', true)
			->where('producto.mostrar_slider', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->select(
				'producto.sku',
				'producto.codigo',
				'producto.nombre',
				'producto.serie',
				'producto.resumen',
				'producto.imagen_portada',
				'producto.published',
				'producto.en_oferta',
				'producto.mostrar_precio',
				'producto.pvp',
				'producto.mostrar_slider',
				'producto.selector',
				'marca_producto.nombre AS marca_nombre'
			)
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->skip($start)
			->take($rowperpage)
			->get();
		$data_arr = array();
		foreach ($records as $row) {
			$oferta = '';
			$slider = '';
			$urlFile = '';
			$linkImage = '';
			$estado = '<span class="badge badge-danger"><i class="fa fa-flag"> </i> <strong>' . trans('labels.borrador') . '</strong> </span>';
			if ($row->en_oferta)
				$oferta = '<button class="btn btn-danger btn-xs" type="button"> ' . strtoupper(trans('ecommerce.oferta')) . ' </button>';
			if ($row->mostrar_slider)
				$slider = '<button class="btn btn-warning btn-xs" type="button"> ' . strtoupper(trans('ecommerce.slider')) . ' </button>';
			if ($row->published)
				$estado = '<span class="badge badge-successful"><i class="fa fa-flag"> </i> <strong>' . trans('labels.publicado') . '</strong> </span>';

			$dataCodigo = '';
			$dataSerie = '';
			if ($row->codigo != '')
				$dataCodigo = trans('labels.codigo') . ': ' . $row->codigo;
			if ($row->serie != '')
				$dataSerie = trans('labels.serie') . ': ' . $row->serie;
			$opciones = '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.ver') . '"><a href="' . route('productos.show', $row->selector) . '" class="btn btn-default"><i class="fa fa-eye"></i></a></span>';

			if (!empty($row->imagen_portada)) {
				$urlFile = URL::to('/') . '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'product/' . $row->selector . '/' . $row->imagen_portada;
				$linkImage = '<a href="' . $urlFile . '" data-lightbox="product-' . $row->id . '" data-title="' . $row->nombre . '"><img alt="' . $row->nombre . '" class="" width="80" src="' . $urlFile . '"></a>';
			}

			$data_arr[] = array(
				"imagen_portada" => $linkImage,
				"nombre" => '<a href="' . route('productos.show', $row->selector) . '"><strong>' . $row->nombre . '</strong></a><br />' . $row->resumen . '.<br/>' . $oferta . ' ' . $slider,
				"sku" => $row->sku,
				"codigo" => $dataCodigo . '<br />' . $dataSerie,
				"precio" => $row->pvp,
				"marca_nombre" => ($row->marca_nombre != null) ? $row->marca_nombre : '',
				"estado" => $estado,
				"opciones" => $opciones
			);
		}
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);
		return response()->json($response);
	}

	public static function getProductosOferta($draw, $start, $rowperpage, $columnIndex_arr, $columnName_arr, $order_arr, $search_arr)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$utilEcommerce = new UtilEcommerce();

		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value

		// Total records
		$totalRecords = Producto::select('count(*) as allcount')
			->where('producto.published', true)
			->where('producto.en_oferta', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->count();

		$totalRecordswithFilter = Producto::select('count(*) as allcount')
			->where('producto.published', true)
			->where('producto.en_oferta', true)
			->where('producto.enabled', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->count();

		// Fetch records
		//$records = Producto::orderBy($columnName,$columnSortOrder)
		$records = Producto::orderBy('producto.orden', 'asc')
			->where('producto.published', true)
			->where('producto.enabled', true)
			->where('producto.en_oferta', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->select(
				'producto.sku',
				'producto.codigo',
				'producto.nombre',
				'producto.serie',
				'producto.resumen',
				'producto.imagen_portada',
				'producto.published',
				'producto.en_oferta',
				'producto.mostrar_precio',
				'producto.pvp',
				'producto.mostrar_slider',
				'producto.selector',
				'marca_producto.nombre AS marca_nombre'
			)
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->skip($start)
			->take($rowperpage)
			->get();
		$data_arr = array();
		foreach ($records as $row) {
			$oferta = '';
			$slider = '';
			$urlFile = '';
			$linkImage = '';
			$estado = '<span class="badge badge-danger"><i class="fa fa-flag"> </i> <strong>' . trans('labels.borrador') . '</strong> </span>';
			if ($row->en_oferta)
				$oferta = '<button class="btn btn-danger btn-xs" type="button"> ' . strtoupper(trans('ecommerce.oferta')) . ' </button>';
			if ($row->mostrar_slider)
				$slider = '<button class="btn btn-warning btn-xs" type="button"> ' . strtoupper(trans('ecommerce.slider')) . ' </button>';
			if ($row->published)
				$estado = '<span class="badge badge-successful"><i class="fa fa-flag"> </i> <strong>' . trans('labels.publicado') . '</strong> </span>';

			$dataCodigo = '';
			$dataSerie = '';
			if ($row->codigo != '')
				$dataCodigo = trans('labels.codigo') . ': ' . $row->codigo;
			if ($row->serie != '')
				$dataSerie = trans('labels.serie') . ': ' . $row->serie;
			$opciones = '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.ver') . '"><a href="' . route('productos.show', $row->selector) . '" class="btn btn-default"><i class="fa fa-eye"></i></a></span>';

			if (!empty($row->imagen_portada)) {
				$urlFile = URL::to('/') . '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'product/' . $row->selector . '/' . $row->imagen_portada;
				$linkImage = '<a href="' . $urlFile . '" data-lightbox="product-' . $row->id . '" data-title="' . $row->nombre . '"><img alt="' . $row->nombre . '" class="" width="80" src="' . $urlFile . '"></a>';
			}

			$data_arr[] = array(
				"imagen_portada" => $linkImage,
				"nombre" => '<a href="' . route('productos.show', $row->selector) . '"><strong>' . $row->nombre . '</strong></a><br />' . $row->resumen . '.<br/>' . $oferta . ' ' . $slider,
				"sku" => $row->sku,
				"codigo" => $dataCodigo . '<br />' . $dataSerie,
				"precio" => $row->pvp,
				"marca_nombre" => ($row->marca_nombre != null) ? $row->marca_nombre : '',
				"estado" => $estado,
				"opciones" => $opciones
			);
		}
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);
		return response()->json($response);
	}

	public static function getProductosDraft($draw, $start, $rowperpage, $columnIndex_arr, $columnName_arr, $order_arr, $search_arr)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$utilEcommerce = new UtilEcommerce();

		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value

		// Total records
		$totalRecords = Producto::select('count(*) as allcount')
			->where('producto.published', false)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->count();

		$totalRecordswithFilter = Producto::select('count(*) as allcount')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.published', false)
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->count();

		// Fetch records
		$records = Producto::orderBy($columnName, $columnSortOrder)
			->where('producto.published', false)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->select(
				'producto.sku',
				'producto.codigo',
				'producto.nombre',
				'producto.serie',
				'producto.resumen',
				'producto.imagen_portada',
				'producto.published',
				'producto.en_oferta',
				'producto.mostrar_precio',
				'producto.pvp',
				'producto.mostrar_slider',
				'producto.selector',
				'marca_producto.nombre AS marca_nombre'
			)
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->skip($start)
			->take($rowperpage)
			->get();
		$data_arr = array();
		foreach ($records as $row) {
			$oferta = '';
			$slider = '';
			$urlFile = '';
			$linkImage = '';

			$estado = '<span class="badge badge-danger"><i class="fa fa-flag"> </i> <strong>' . trans('labels.borrador') . '</strong> </span>';
			if ($row->en_oferta)
				$oferta = '<button class="btn btn-danger btn-xs" type="button"> ' . strtoupper(trans('ecommerce.oferta')) . ' </button>';
			if ($row->mostrar_slider)
				$slider = '<button class="btn btn-warning btn-xs" type="button"> ' . strtoupper(trans('ecommerce.slider')) . ' </button>';
			if ($row->published)
				$estado = '<span class="badge badge-successful"><i class="fa fa-flag"> </i> <strong>' . trans('labels.publicado') . '</strong> </span>';

			$dataCodigo = '';
			$dataSerie = '';
			if ($row->codigo != '')
				$dataCodigo = trans('labels.codigo') . ': ' . $row->codigo;
			if ($row->serie != '')
				$dataSerie = trans('labels.serie') . ': ' . $row->serie;
			$opciones = '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.ver') . '"><a href="' . route('productos.show', $row->selector) . '" class="btn btn-default"><i class="fa fa-eye"></i></a></span>';
			if (!empty($row->imagen_portada)) {
				$urlFile = URL::to('/') . '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'product/' . $row->selector . '/' . $row->imagen_portada;
				$linkImage = '<a href="' . $urlFile . '" data-lightbox="product-' . $row->id . '" data-title="' . $row->nombre . '"><img alt="' . $row->nombre . '" class="" width="80" src="' . $urlFile . '"></a>';
			}

			$data_arr[] = array(
				"imagen_portada" => $linkImage,
				"nombre" => '<a href="' . route('productos.show', $row->selector) . '"><strong>' . $row->nombre . '</strong></a><br />' . $row->resumen . '.<br/>' . $oferta . ' ' . $slider,
				"sku" => $row->sku,
				"codigo" => $dataCodigo . '<br />' . $dataSerie,
				"precio" => $row->pvp,
				"marca_nombre" => ($row->marca_nombre != null) ? $row->marca_nombre : '',
				"estado" => $estado,
				"opciones" => $opciones
			);
		}
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);
		return response()->json($response);
	}

	public static function getProductosData($draw, $start, $rowperpage, $columnIndex_arr, $columnName_arr, $order_arr, $search_arr)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$utilEcommerce = new UtilEcommerce();

		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value

		// Total records
		$totalRecords = Producto::select('count(*) as allcount')
			->where('producto.published', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->count();

		$totalRecordswithFilter = Producto::select('count(*) as allcount')
			->where('producto.published', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->count();

		// Fetch records
		$records = Producto::orderBy($columnName, $columnSortOrder)
			->where('producto.published', true)
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where(function ($query) use ($searchValue) {
				$query->where('producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.resumen', 'like', '%' . $searchValue . '%');
				$query->orWhere('marca_producto.nombre', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.sku', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.codigo', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.serie', 'like', '%' . $searchValue . '%');
				$query->orWhere('producto.pvp', 'like', '%' . $searchValue . '%');
			})
			->select(
				'producto.sku',
				'producto.codigo',
				'producto.nombre',
				'producto.serie',
				'producto.resumen',
				'producto.imagen_portada',
				'producto.published',
				'producto.en_oferta',
				'producto.mostrar_precio',
				'producto.pvp',
				'producto.mostrar_slider',
				'producto.selector',
				'marca_producto.nombre AS marca_nombre'
			)
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->skip($start)
			->take($rowperpage)
			->get();
		$data_arr = array();
		foreach ($records as $row) {
			$oferta = '';
			$slider = '';
			$estado = '<span class="badge badge-danger"><i class="fa fa-flag"> </i> <strong>' . trans('labels.borrador') . '</strong> </span>';
			if ($row->en_oferta)
				$oferta = '<button class="btn btn-danger btn-xs" type="button"> ' . strtoupper(trans('ecommerce.oferta')) . ' </button>';
			if ($row->mostrar_slider)
				$slider = '<button class="btn btn-warning btn-xs" type="button"> ' . strtoupper(trans('ecommerce.slider')) . ' </button>';
			if ($row->published)
				$estado = '<span class="badge badge-successful"><i class="fa fa-flag"> </i> <strong>' . trans('labels.publicado') . '</strong> </span>';

			$dataCodigo = '';
			$dataSerie = '';
			$urlFile = '';
			$linkImage = '';
			if ($row->codigo != '')
				$dataCodigo = trans('labels.codigo') . ': ' . $row->codigo;
			if ($row->serie != '')
				$dataSerie = trans('labels.serie') . ': ' . $row->serie;
			$opciones = '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.ver') . '"><a href="' . route('productos.show', $row->selector) . '" class="btn btn-default"><i class="fa fa-eye"></i></a></span>';
			if (!empty($row->imagen_portada)) {
				$urlFile = URL::to('/') . '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'product/' . $row->selector . '/' . $row->imagen_portada;
				$linkImage = '<a href="' . $urlFile . '" data-lightbox="product-' . $row->id . '" data-title="' . $row->nombre . '"><img alt="' . $row->nombre . '" class="" width="80" src="' . $urlFile . '"></a>';
			}
			$data_arr[] = array(
				"imagen_portada" => $linkImage,
				"nombre" => '<a href="' . route('productos.show', $row->selector) . '"><strong>' . $row->nombre . '</strong></a><br />' . $row->resumen . '.<br/>' . $oferta . ' ' . $slider,
				"sku" => $row->sku,
				"codigo" => $dataCodigo . '<br />' . $dataSerie,
				"precio" => $row->pvp,
				"marca_nombre" => ($row->marca_nombre != null) ? $row->marca_nombre : '',
				"estado" => $estado,
				"opciones" => $opciones
			);
		}
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);
		return response()->json($response);
	}

	public static function getProductoById($id)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = Producto::query()
			->select('producto.*', 'marca_producto.nombre AS marca_nombre', 'categoria_producto.nombre AS categoria_nombre', 'MEDIDA.nombre AS medida_nombre', 'PESO.nombre AS peso_nombre')
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->leftJoin('categoria_producto', 'producto.categoria_principal_id', '=', 'categoria_producto.id')
			->leftJoin('item_catalogo AS MEDIDA', 'producto.unidad_medida_id', '=', 'MEDIDA.id')
			->leftJoin('item_catalogo AS PESO', 'producto.unidad_peso_id', '=', 'PESO.id')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.id', $id)
			->first();
		return $data;
	}

	public static function getProductoBySelector($selector)
	{
		$authUtil = new AuthUtil();
		$constants = new Constants();
		$data = Producto::query()
			->select('producto.*', 'marca_producto.nombre AS marca_nombre', 'categoria_producto.nombre AS categoria_nombre', 'MEDIDA.nombre AS medida_nombre', 'PESO.nombre AS peso_nombre')
			->leftJoin('marca_producto', 'producto.marca_id', '=', 'marca_producto.id')
			->leftJoin('categoria_producto', 'producto.categoria_principal_id', '=', 'categoria_producto.id')
			->leftJoin('item_catalogo AS MEDIDA', 'producto.unidad_medida_id', '=', 'MEDIDA.id')
			->leftJoin('item_catalogo AS PESO', 'producto.unidad_peso_id', '=', 'PESO.id')
			->where('producto.sitio_id', $authUtil->getServiceContextValue($constants->contextSitioId))
			->where('producto.selector', $selector)
			->first();
		return $data;
	}

	public function marca_producto()
	{
		return $this->belongsTo(MarcaProducto::class, 'marca_id');
	}

	public function sitio()
	{
		return $this->belongsTo(Sitio::class);
	}

	public function item_catalogo()
	{
		return $this->belongsTo(ItemCatalogo::class, 'unidad_peso_id');
	}

	public function pedido_detalles()
	{
		return $this->hasMany(PedidoDetalle::class);
	}

	public function producto_categoria()
	{
		return $this->hasMany(ProductoCategorium::class);
	}

	public function producto_recursos()
	{
		return $this->hasMany(ProductoRecurso::class);
	}

	public function producto_relacions()
	{
		return $this->hasMany(ProductoRelacion::class, 'relacion_producto_id');
	}
}
