<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'equipo_id',
        'solicitante',
        'fechaNecesidad',
        'asignadoA',
        'prioridad',
        'aprobadoPor',
        'fechaEntrega',
        'realizadoPor',
        'fechaAprobado',
        'det1',
        'det2',
        'det3',
        'estado',
    ];

    /**
     * Relación con el modelo Equipo.
     */
    public function equipos()
    {
        return $this->belongsTo(\App\Models\Equipo::class); // Por ahora no cambio convenciones de nombres.
    }

    /**
     * Validaciones dinámicas según el estado de la orden.
     */
    public function validate()
    {
        // Reglas para estado "Abierta"
        if ($this->estado === 'Abierta') {
            return request()->validate([
                'solicitante' => 'required|string',
                'asignadoA' => 'required|exists:users,id',
                'equipo_id' => 'required|exists:equipos,id',
                'fechaNecesidad' => 'required|date',
                'prioridad' => 'required|string',
                'det1' => 'nullable|string|max:500',
            ]);
        }

        // Reglas para estado "Cerrada"
        if ($this->estado === 'Cerrada') {
            return request()->validate([
                'aprobadoPor' => 'required|string',
                'fechaEntrega' => 'required|date',
                'realizadoPor' => 'nullable|string|max:500',
                'fechaAprobado' => 'required|date',
                'det2' => 'nullable|string|max:500',
                'det3' => 'nullable|string|max:500',
            ]);
        }

        // Si no hay reglas específicas, retorna un array vacío
        return [];
    }
}
