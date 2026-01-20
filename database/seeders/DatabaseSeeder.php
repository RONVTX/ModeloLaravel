<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Alumno;
use App\Models\Materia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear Usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear Alumnos
        $alumno1 = Alumno::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '123456789'
        ]);

        $alumno2 = Alumno::create([
            'nombre' => 'María García',
            'email' => 'maria@example.com',
            'telefono' => '987654321'
        ]);

        $alumno3 = Alumno::create([
            'nombre' => 'Carlos López',
            'email' => 'carlos@example.com',
            'telefono' => '555555555'
        ]);

        // Crear Materias
        $matematicas = Materia::create([
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Cálculo y álgebra avanzada',
            'creditos' => 4
        ]);

        $historia = Materia::create([
            'nombre_materia' => 'Historia',
            'descripcion' => 'Historia Universal',
            'creditos' => 3
        ]);

        $programacion = Materia::create([
            'nombre_materia' => 'Programación',
            'descripcion' => 'Desarrollo con Laravel',
            'creditos' => 5
        ]);

        $ingles = Materia::create([
            'nombre_materia' => 'Inglés',
            'descripcion' => 'Nivel intermedio',
            'creditos' => 3
        ]);

        // Asignar materias a alumnos (relación many-to-many)
        // Juan cursa Matemáticas, Historia y Programación
        $alumno1->materias()->attach($matematicas->id);
        $alumno1->materias()->attach($historia->id);
        $alumno1->materias()->attach($programacion->id);

        // María cursa Programación, Inglés y Matemáticas
        $alumno2->materias()->attach($programacion->id);
        $alumno2->materias()->attach($ingles->id);
        $alumno2->materias()->attach($matematicas->id);

        // Carlos cursa Historia, Inglés y Programación
        $alumno3->materias()->attach($historia->id);
        $alumno3->materias()->attach($ingles->id);
        $alumno3->materias()->attach($programacion->id);
    }
}
