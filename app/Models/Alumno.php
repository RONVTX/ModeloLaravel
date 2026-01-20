<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = ['nombre', 'email', 'telefono'];

    /**
     * Relación muchos a muchos con Materias
     */
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'alumno_materia', 'alumno_id', 'materia_id')
                    ->withPivot('calificacion')
                    ->withTimestamps();
    }
}
