<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenTrabajoController;



Route::get('/', function () {
    return view('welcome');
});
 //**************************************************************************** */
 
 Route::resource('ordentrabajo', OrdenTrabajoController::class);
 Route::get('ordentrabajo/createorden/{equipo}', [OrdenTrabajoController::class, 'createorden'])->name('ordentrabajo.createorden');
 Route::get('ordentrabajo/show/{ordendetrabajo}', [OrdenTrabajoController::class, 'show'])->name('ordentrabajo.show');
 Route::get('ordentrabajo/showCerrar/{ordendetrabajo}', [OrdenTrabajoController::class, 'showCerrar'])->name('ordentrabajo.showCerrar');
 Route::get('ordentrabajo/list/{equipo}', [OrdenTrabajoController::class, 'list'])->name('ordentrabajo.list');
