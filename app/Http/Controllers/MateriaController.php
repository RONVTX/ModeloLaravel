<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Alumno;

class MateriaController extends Controller
{
    /**
     * Mostrar todas las materias con sus alumnos
     */
    public function index()
    {
        $materias = Materia::with('alumnos')->get();
        return response()->json($materias);
    }

    /**
     * Mostrar una materia específica con sus alumnos
     */
    public function show($id)
    {
        $materia = Materia::with('alumnos')->find($id);
        
        if (!$materia) {
            return response()->json(['error' => 'Materia no encontrada'], 404);
        }
        
        return response()->json($materia);
    }

    /**
     * Obtener todos los alumnos que cursan una materia
     */
    public function alumnosMateria($id)
    {
        $materia = Materia::find($id);

        if (!$materia) {
            return response()->json(['error' => 'Materia no encontrada'], 404);
        }

        $alumnos = $materia->alumnos()->get();
        
        return response()->json([
            'materia' => $materia->nombre_materia,
            'alumnos' => $alumnos,
            'total' => $alumnos->count()
        ]);
    }

    /**
     * Obtener materias por número de créditos mínimo
     */
    public function materiasPorCreditos($creditos)
    {
        $materias = Materia::where('creditos', '>=', $creditos)->get();
        return response()->json($materias);
    }

    /**
     * Obtener los alumnos que NO cursan una materia específica
     */
    public function alumnosSinMateria($materiaId)
    {
        $materia = Materia::find($materiaId);

        if (!$materia) {
            return response()->json(['error' => 'Materia no encontrada'], 404);
        }

        // Alumnos que NO cursan esta materia
        $alumnos = Alumno::whereDoesntHave('materias', function ($query) use ($materiaId) {
            $query->where('materia_id', $materiaId);
        })->get();

        return response()->json([
            'materia' => $materia->nombre_materia,
            'alumnos_sin_materia' => $alumnos,
            'total' => $alumnos->count()
        ]);
    }
}
