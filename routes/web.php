<?php

use App\Http\Controllers\Admin\CatastroSolicitudesController;
use App\Http\Livewire\Admin\Roles;
use App\Http\Livewire\Admin\Permisos;
use App\Http\Livewire\Admin\Usuarios;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\ReportesRpp;
use App\Http\Livewire\Admin\RppArchivos;
use App\Http\Controllers\ManualController;
use App\Http\Livewire\Admin\SolicitudesRpp;
use App\Http\Livewire\Admin\CatastroArchivo;
use App\Http\Livewire\Admin\DistribuidorRpp;
use App\Http\Livewire\Admin\ReportesCatastro;
use App\Http\Controllers\SetPasswordController;
use App\Http\Livewire\Admin\SolicitudesCatastro;
use App\Http\Livewire\Admin\DistribuidorCatastro;
use App\Http\Controllers\Admin\DashboardController;

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
Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::group(['middleware' => ['auth', 'is.active']], function(){

    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('usuarios', Usuarios::class)->name('usuarios');

    Route::get('permisos', Permisos::class)->name('permisos');

    Route::get('roles', Roles::class)->name('roles');

    Route::get('catastro_archivos', CatastroArchivo::class)->name('catastro_archivos');

    Route::get('rpp_archivos', RppArchivos::class)->name('rpp_archivos');

    Route::get('rpp_solicitudes', SolicitudesRpp::class)->name('rpp_solicitudes');

    Route::get('catastro_solicitudes', SolicitudesCatastro::class)->name('catastro_solicitudes');
    Route::get('catastro_solicitudes/lista/{solicitud}', [CatastroSolicitudesController::class, 'imprimirLista'])->name('solicitudes.lista');

    Route::get('distribuidor_rpp', DistribuidorRpp::class)->name('distribuidor_rpp');

    Route::get('distribuidor_catastro', DistribuidorCatastro::class)->name('distribuidor_catastro');

    Route::get('reportes_catastro', ReportesCatastro::class)->name('reportes_catastro');

    Route::get('reportes_rpp', ReportesRpp::class)->name('reportes_rpp');

});

Route::get('manual', ManualController::class)->name('manual');
