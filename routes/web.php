<?php

use App\Http\Livewire\Admin\Roles;
use App\Http\Livewire\Admin\Permisos;
use App\Http\Livewire\Admin\Usuarios;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Auditoria;
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
use App\Http\Controllers\Admin\CatastroSolicitudesController;
use App\Http\Controllers\LimpiarArchivoController;

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

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => ['auth', 'is.active']], function(){

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('catastro_archivos', CatastroArchivo::class)->middleware('permission:Lista de archivos catastro')->name('catastro_archivos');

    Route::get('rpp_archivos', RppArchivos::class)->middleware('permission:Lista de archivos rpp')->name('rpp_archivos');

    Route::get('rpp_solicitudes', SolicitudesRpp::class)->middleware('permission:Lista de solicitudes rpp')->name('rpp_solicitudes');

    Route::get('catastro_solicitudes', SolicitudesCatastro::class)->middleware('permission:Lista de solicitudes catastro')->name('catastro_solicitudes');
    Route::get('catastro_solicitudes/lista/{solicitud}', [CatastroSolicitudesController::class, 'imprimirLista'])->name('solicitudes.lista');

    Route::get('distribuidor_rpp', DistribuidorRpp::class)->middleware('permission:Distribución RPP')->name('distribuidor_rpp');

    Route::get('distribuidor_catastro', DistribuidorCatastro::class)->middleware('permission:Distribución Catastro')->name('distribuidor_catastro');

    Route::get('reportes_catastro', ReportesCatastro::class)->middleware('permission:Reportes Catastro')->name('reportes_catastro');

    Route::get('reportes_rpp', ReportesRpp::class)->middleware('permission:Reportes Rpp')->name('reportes_rpp');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('test', LimpiarArchivoController::class);

});

Route::get('manual', ManualController::class)->name('manual');
