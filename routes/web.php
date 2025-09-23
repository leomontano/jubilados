<?php

use App\Http\Controllers\AsociadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::view('/', 'welcome')->name('inicio');

Route::get('/', [GeneralController::class, 'index'])->name('inicio');

// route::view('ruta','archivo blade');

// Route::get('asociado', [AsociadoController::class,'index'])->name('asociados.index');
// Route::get('asociado/create', [AsociadoController::class,'create'])->name('asociados.create');
// Route::post('asociado', [AsociadoController::class,'store'])->name('asociados.store');
// Route::get('asociado/{asociado}', [AsociadoController::class,'show'])->name('asociados.show');
// Route::get('asociado/{asociado}/edit', [AsociadoController::class,'edit'])->name('asociados.edit');
// Route::patch('asociado/{asociado}', [AsociadoController::class,'update'])->name('asociados.update');
// Route::delete('asociado/{asociado}', [AsociadoController::class,'destroy'])->name('asociados.destroy');


Route::resource('asociado',AsociadoController::class,[
        'names' => 'asociados',
        'parameters' => [ 'asociado' => 'asociado']
     ]);


Route::get('recibo', [ReciboController::class,'index'])->name('recibo');
Route::get('recibo/{matricula}', [ReciboController::class,'indexmatricula'])->name('recibomatricula');

Route::get('/recibos/create/{matricula}', [ReciboController::class, 'create'])->name('recibos.create');
Route::post('/recibos/store', [ReciboController::class, 'store'])->name('recibos.store');
Route::get('/recibos/print/{id}/{reimpresion}', [ReciboController::class, 'print'])->name('recibos.print');
Route::delete('/recibos/{id}', [ReciboController::class, 'destroy'])->name('recibos.destroy');


Route::get('/corte', [CorteController::class, 'index'])->name('corte.index');
Route::get('/corte/print', [CorteController::class, 'print'])->name('corte.print');
Route::get('/corte/print-detalle', [CorteController::class, 'printDetalle'])->name('corte.printDetalle');

Route::get('asistencia', [AsistenciaController::class,'index'])->name('asistencia');
Route::get('/asistencias/reporte/{anio}', [AsistenciaController::class, 'reporte'])
    ->name('asistencias.reporte');

Route::get('/generals/edit', [GeneralController::class, 'edit'])->name('generals.edit');
Route::post('/generals/update', [GeneralController::class, 'update'])->name('generals.update');



Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('/backup/runFTP', [BackupController::class, 'runFTP'])->name('backup.runFTP');



// Route::view('asociado', 'asociado')->name('asociado');
// Route::view('recibo', 'recibo')->name('recibo');


// route::view('Url','Vista', [Array Datos])->name('about');

// Route::resource('blog', PostController::class,[
//     'names' => 'posts',
//     'parameters' => [
//         'blog' => 'post',
//     ],
// ]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
