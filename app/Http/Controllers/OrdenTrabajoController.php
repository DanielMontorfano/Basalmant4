<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrdenRequest; 
use App\Http\Requests\StoreOrdenCerrarRequest; 

class OrdenTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index()
     {
         $ordenes = OrdenTrabajo::paginate(10);  // Asegúrate de usar paginación si hay muchas órdenes
         return view('filament.ordentrabajo.index', compact('ordenes'));
     }



}
