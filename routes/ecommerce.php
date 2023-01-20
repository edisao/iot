<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaProductosController;
use App\Http\Controllers\MarcaProductosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProductoRecursosController;
use App\Http\Controllers\ProductoCategoriasController;
use App\Http\Controllers\ProductoRelacionesController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PedidoDetallesController;

// categoriaProductos
Route::get('categoriaProductos/{categoriaProducto}/enabled', [CategoriaProductosController::class, 'enabled'])->name('categoriaProductos.enabled')->middleware(['authorization', 'log_context']);
Route::get('categoriaProductos/{categoriaProducto}/delete', [CategoriaProductosController::class, 'destroy'])->name('categoriaProductos.delete')->middleware(['authorization', 'log_context']);
Route::get('categoriaProductos/data', [CategoriaProductosController::class, 'data'])->name('categoriaProductos.data')->middleware(['authorization', 'log_context']);
Route::resource('categoriaProductos', CategoriaProductosController::class)->middleware(['authorization', 'log_context']);

// marcaProductos
Route::get('marcaProductos/{marcaProducto}/enabled', [MarcaProductosController::class, 'enabled'])->name('marcaProductos.enabled')->middleware(['authorization', 'log_context']);
Route::get('marcaProductos/{marcaProducto}/delete', [MarcaProductosController::class, 'destroy'])->name('marcaProductos.delete')->middleware(['authorization', 'log_context']);
Route::get('marcaProductos/data', [MarcaProductosController::class, 'data'])->name('marcaProductos.data')->middleware(['authorization', 'log_context']);
Route::resource('marcaProductos', MarcaProductosController::class)->middleware(['authorization', 'log_context']);

// productos
Route::get('productos/draft', [ProductosController::class, 'indexDraft'])->name('productos.draft')->middleware(['authorization', 'log_context']);
Route::get('productos/ofert', [ProductosController::class, 'indexOfert'])->name('productos.ofert')->middleware(['authorization', 'log_context']);
Route::get('productos/ofert/order', [ProductosController::class, 'orderOfert'])->name('productos.orderOfert')->middleware(['authorization', 'log_context']);
Route::get('productos/slider', [ProductosController::class, 'indexSlider'])->name('productos.slider')->middleware(['authorization', 'log_context']);
Route::get('productos/slider/order', [ProductosController::class, 'orderSlider'])->name('productos.orderSlider')->middleware(['authorization', 'log_context']);

Route::get('productos/{producto}/enabled', [ProductosController::class, 'enabled'])->name('productos.enabled')->middleware(['authorization', 'log_context']);
Route::get('productos/{producto}/delete', [ProductosController::class, 'destroy'])->name('productos.delete')->middleware(['authorization', 'log_context']);
Route::get('productos/data', [ProductosController::class, 'data'])->name('productos.data')->middleware(['authorization', 'log_context']);
Route::resource('productos', ProductosController::class)->except(['show'])->middleware(['authorization', 'log_context']);
Route::get('productos/{selector}', [ProductosController::class, 'show'])->name('productos.show')->middleware(['authorization', 'log_context']);

Route::post('productos/updateOrder/ofert', [ProductosController::class, 'updateOrderOfert'])->name('productos.updateOrderOfert')->middleware(['authorization', 'log_context']);
Route::post('productos/updateOrder/slider', [ProductosController::class, 'updateOrderSlider'])->name('productos.updateOrderSlider')->middleware(['authorization', 'log_context']);
Route::put('productos/{producto}/medidas', [ProductosController::class, 'updateMedidas'])->name('productos.updateMedidas')->middleware(['authorization', 'log_context']);
Route::get('productos/admin/dataDraft', [ProductosController::class, 'dataDraft'])->name('productos.dataDraft')->middleware(['authorization', 'log_context']);
Route::get('productos/admin/dataOfert', [ProductosController::class, 'dataOfert'])->name('productos.dataOfert')->middleware(['authorization', 'log_context']);
Route::get('productos/admin/dataSlider', [ProductosController::class, 'dataSlider'])->name('productos.dataSlider')->middleware(['authorization', 'log_context']);

// producto recursos
Route::get('productoRecursos/{producto}/order', [ProductoRecursosController::class, 'order'])->name('productoRecursos.order')->middleware(['authorization', 'log_context']);
Route::post('productoRecursos', [ProductoRecursosController::class, 'store'])->name('productoRecursos.store')->middleware(['authorization', 'log_context']);
Route::get('productoRecursos/data', [ProductoRecursosController::class, 'data'])->name('productoRecursos.data')->middleware(['authorization', 'log_context']);
Route::put('productoRecursos/{productoRecurso}', [ProductoRecursosController::class, 'update'])->name('productoRecursos.update')->middleware(['authorization', 'log_context']);
Route::post('productoRecursos/updateOrder', [ProductoRecursosController::class, 'updateOrder'])->name('productoRecursos.updateOrder')->middleware(['authorization', 'log_context']);
Route::get('productoRecursos/{productoRecurso}/enabled', [ProductoRecursosController::class, 'enabled'])->name('productoRecursos.enabled')->middleware(['authorization', 'log_context']);
Route::get('productoRecursos/{productoRecurso}/principal', [ProductoRecursosController::class, 'principal'])->name('productoRecursos.principal')->middleware(['authorization', 'log_context']);
Route::get('productoRecursos/{productoRecurso}/edit', [ProductoRecursosController::class, 'edit'])->name('productoRecursos.edit')->middleware(['authorization', 'log_context']);
Route::get('productoRecursos/{productoRecurso}/delete', [ProductoRecursosController::class, 'destroy'])->name('productoRecursos.delete')->middleware(['authorization', 'log_context']);
Route::post('productoRecursos/storeImage', [ProductoRecursosController::class, 'storeImage'])->name('productoRecursos.storeImage')->middleware(['authorization', 'log_context']);

// producto categorias
Route::post('productoCategorias', [ProductoCategoriasController::class, 'store'])->name('productoCategorias.store')->middleware(['authorization', 'log_context']);
Route::get('productoCategorias/data', [ProductoCategoriasController::class, 'data'])->name('productoCategorias.data')->middleware(['authorization', 'log_context']);
Route::get('productoCategorias/{productoCategoria}/principal', [ProductoCategoriasController::class, 'principal'])->name('productoCategorias.principal')->middleware(['authorization', 'log_context']);
Route::get('productoCategorias/{productoCategoria}/delete', [ProductoCategoriasController::class, 'destroy'])->name('productoCategorias.delete')->middleware(['authorization', 'log_context']);

// producto categorias
Route::post('productoRelaciones', [ProductoRelacionesController::class, 'store'])->name('productoRelaciones.store')->middleware(['authorization', 'log_context']);
Route::get('productoRelaciones/{productoRelacion}/delete', [ProductoRelacionesController::class, 'destroy'])->name('productoRelaciones.delete')->middleware(['authorization', 'log_context']);
Route::get('productoRelaciones/data', [ProductoRelacionesController::class, 'data'])->name('productoRelaciones.data')->middleware(['authorization', 'log_context']);

// pedidos
Route::get('pedidos/other', [PedidosController::class, 'indexOther'])->name('pedidos.indexOther')->middleware(['authorization', 'log_context']);
Route::get('pedidos/{pedido}/enabled', [PedidosController::class, 'enabled'])->name('pedidos.enabled')->middleware(['authorization', 'log_context']);
Route::get('pedidos/{pedido}/delete', [PedidosController::class, 'destroy'])->name('pedidos.delete')->middleware(['authorization', 'log_context']);
Route::get('pedidos/data', [PedidosController::class, 'data'])->name('pedidos.data')->middleware(['authorization', 'log_context']);
Route::resource('pedidos', PedidosController::class)->middleware(['authorization', 'log_context']);
Route::get('pedidos/data/other', [PedidosController::class, 'dataOther'])->name('pedidos.dataOther')->middleware(['authorization', 'log_context']);

// pedidoDetalles
Route::get('pedidoDetalles/{pedidoDetalle}/delete', [PedidoDetallesController::class, 'destroy'])->name('pedidoDetalles.delete')->middleware(['authorization', 'log_context']);
Route::get('pedidoDetalles/data', [PedidoDetallesController::class, 'data'])->name('pedidoDetalles.data')->middleware(['authorization', 'log_context']);
Route::put('pedidoDetalles/{pedidoDetalle}', [PedidoDetallesController::class, 'update'])->name('pedidoDetalles.update')->middleware(['authorization', 'log_context']);
Route::get('pedidoDetalles/{pedidoDetalle}/edit', [PedidoDetallesController::class, 'edit'])->name('pedidoDetalles.edit')->middleware(['authorization', 'log_context']);
//Route::resource('pedidoDetalles', PedidoDetallesController::class)->middleware(['authorization', 'log_context']);
