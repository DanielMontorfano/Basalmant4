<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    // Definición de los campos que se pueden asignar masivamente
    // Definición de los campos que se pueden asignar masivamente
protected $fillable = [
    'idSecc',
    'idSubSecc',
    'codEquipo',
    'marca',
    'modelo',
    'det1',
    'det2',
    'det3',
    'det4',
    'det5',
    'histEquipo',
    'creador',
    'slug',
];

    /**
     * Generación de URL amigables.
     *
     * @return string
     */
   /* public function getRouteKeyName()
    {
        return 'slug';
    }*/

    /**
     * Relación de muchos a muchos con el modelo Repuesto.
     */
    /*public function repuestos()
    {
        return $this->belongsToMany(Repuesto::class)
            ->withPivot('cant', 'unidad', 'check1');
    }*/

    public function repuestos()
{
    return $this->belongsToMany(Repuesto::class)
                ->withPivot(['cant', 'unidad']);
}


    /* ************************************************************ */
    /* *************** Relaciones originales del modelo ************ */
    /* ************************************************************ */

    // Relación original: muchos a muchos con Repuestos
    public function equiposRepuestos()
    {
        return $this->belongsToMany('App\Models\Repuesto')
            ->withPivot('cant', 'unidad', 'check1');
    }

    public function ordentrabajo()
    {
        return $this->hasMany('App\Models\OrdenTrabajo'); //Por ahora no cambio conveniccion de nombres
    }

   
    
}
