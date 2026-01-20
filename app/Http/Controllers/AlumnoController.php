<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Materia;

class AlumnoController extends Controller
{
    /**
     * Mostrar todos los alumnos con sus materias
     */
    public function index()
    {
        $alumnos = Alumno::with('materias')->get();
        return response()->json($alumnos);
    }

    /**
     * Mostrar un alumno específico con sus materias
     */
    public function show($id)
    {
        $alumno = Alumno::with('materias')->find($id);
        
        if (!$alumno) {
            return response()->json(['error' => 'Alumno no encontrado'], 404);
        }
        
        return response()->json($alumno);
    }

    /**
     * Asignar una materia a un alumno
     */
    public function asignarMateria($alumnoId, $materiaId)
    {
        $alumno = Alumno::find($alumnoId);
        $materia = Materia::find($materiaId);

        if (!$alumno || !$materia) {
            return response()->json(['error' => 'Alumno o Materia no encontrados'], 404);
        }

        // Usar attach para agregar la materia al alumno
        $alumno->materias()->attach($materia->id);

        return response()->json(['mensaje' => 'Materia asignada correctamente', 'alumno' => $alumno->load('materias')]);
    }

    /**
     * Desasignar una materia de un alumno
     */
    public function desasignarMateria($alumnoId, $materiaId)
    {
        $alumno = Alumno::find($alumnoId);

        if (!$alumno) {
            return response()->json(['error' => 'Alumno no encontrado'], 404);
        }

        // Usar detach para remover la materia del alumno
        $alumno->materias()->detach($materiaId);

        return response()->json(['mensaje' => 'Materia desasignada correctamente', 'alumno' => $alumno->load('materias')]);
    }

    /**
     * Obtener todas las materias de un alumno
     */
    public function materiasAlumno($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json(['error' => 'Alumno no encontrado'], 404);
        }

        $materias = $alumno->materias()->get();
        
        return response()->json([
            'alumno' => $alumno->nombre,
            'materias' => $materias,
            'total' => $materias->count()
        ]);
    }

    /**
     * Actualizar calificación en la tabla pivot
     */
    public function actualizarCalificacion($alumnoId, $materiaId, $calificacion)
    {
        $alumno = Alumno::find($alumnoId);
        $materia = Materia::find($materiaId);

        if (!$alumno || !$materia) {
            return response()->json(['error' => 'Alumno o Materia no encontrados'], 404);
        }

        // Actualizar la calificación en la tabla pivot
        $alumno->materias()->updateExistingPivot($materiaId, ['calificacion' => $calificacion]);

        return response()->json(['mensaje' => 'Calificación actualizada', 'alumno' => $alumno->load('materias')]);
    }
}
