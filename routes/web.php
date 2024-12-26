<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenTrabajoController;



Route::get('/', function () {
    return view('welcome');
});
 //**************************************************************************** */
 
 Route::resource('ordentrabajo', OrdenTrabajoController::class);
 
