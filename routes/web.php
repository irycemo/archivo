<?php



use App\Http\Livewire\Admin\Roles;
use App\Http\Livewire\Admin\Permisos;
use App\Http\Livewire\Admin\Usuarios;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\RppArchivos;
use App\Http\Livewire\Admin\CatastroArchivo;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function(){

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('usuarios', Usuarios::class)->name('usuarios');

    Route::get('permisos', Permisos::class)->name('permisos');

    Route::get('roles', Roles::class)->name('roles');

    Route::get('catastro_archivos', CatastroArchivo::class)->name('catastro_archivos');

    Route::get('rpp_archivos', RppArchivos::class)->name('rpp_archivos');

});
