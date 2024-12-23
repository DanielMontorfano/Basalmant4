<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EquipoRepuesto extends Pivot
{
    protected $table = 'equipo_repuesto'; //Importantisimo personalisar el nombre de la tabla, sobre todo en tablas pivot!!!!!

    protected $fillable = [
        'equipo_id',
        'repuesto_id',
        'cant',
        'unidad',
        'check1',
    ]; // Campos que puedes asignar masivamente

    public $timestamps = true; // Mantén timestamps si tu tabla los tiene
}
