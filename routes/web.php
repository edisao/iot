<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParametrosController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\ItemCatalogosController;
use App\Http\Controllers\FuncionalidadesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\SitiosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IotsController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\MatrizNotificacionesController;
use App\Http\Controllers\UsuarioRecursosController;
use App\Http\Controllers\SitioAlertasController;
use App\Http\Controllers\UsuarioSitiosController;
use App\Http\Controllers\SitioPersonasController;
use App\Http\Controllers\IpBlacklistsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('auth/loginValidate', [AuthController::class, 'login'])->name('auth.login')->middleware(['log_context']);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['authorization', 'log_context']);
Route::get('dashboard/events', [DashboardController::class, 'events'])->name('dashboard.events')->middleware(['authorization', 'log_context']);

// Logs viewer
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs')->middleware(['authorization']);

// iot
Route::post('iots', [IotsController::class, 'deleteData'])->name('iots.deleteData')->middleware(['authorization', 'log_context']);
Route::get('iots/{iot}/delete', [IotsController::class, 'destroy'])->name('iots.delete')->middleware(['authorization', 'log_context']);
Route::get('iots/data', [IotsController::class, 'data'])->name('iots.data')->middleware(['authorization', 'log_context']);
Route::get('iots/', [IotsController::class, 'index'])->name('iots.index')->middleware(['authorization', 'log_context']);
Route::get('iots/chart', [IotsController::class, 'chart'])->name('iots.chart')->middleware(['authorization', 'log_context']);
Route::get('iots/data/chart', [IotsController::class, 'dataChart'])->name('iots.dataChart')->middleware(['authorization', 'log_context']);
