<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    use HasFactory;

    /**
     * Relación de muchos a muchos con el modelo Equipo.
     * Incluye atributos adicionales en la tabla pivote: cantidad y unidad.
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class)
            ->withPivot('cant', 'unidad');
    }

    
}
