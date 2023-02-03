<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IotsController;
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
