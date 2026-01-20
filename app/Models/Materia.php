<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nombre_materia', 'descripcion', 'creditos'];

    /**
     * Relación muchos a muchos con Alumnos
     */
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_materia', 'materia_id', 'alumno_id')
                    ->withPivot('calificacion')
                    ->withTimestamps();
    }
}
