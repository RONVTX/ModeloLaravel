# Rutas para la APP de Alumnos y Materias

## Rutas de Alumnos

### Obtener todos los alumnos con sus materias
GET /api/alumnos

### Obtener un alumno específico
GET /api/alumnos/{id}

### Obtener materias de un alumno
GET /api/alumnos/{id}/materias

### Asignar una materia a un alumno
POST /api/alumnos/{alumno_id}/materias/{materia_id}

### Desasignar una materia de un alumno
DELETE /api/alumnos/{alumno_id}/materias/{materia_id}

### Actualizar calificación
PUT /api/alumnos/{alumno_id}/materias/{materia_id}/calificacion/{calificacion}

---

## Rutas de Materias

### Obtener todas las materias con sus alumnos
GET /api/materias

### Obtener una materia específica
GET /api/materias/{id}

### Obtener alumnos de una materia
GET /api/materias/{id}/alumnos

### Obtener materias por número de créditos
GET /api/materias/creditos/{creditos}

### Obtener alumnos que NO cursan una materia
GET /api/materias/{id}/sin-alumnos

---

## Ejemplo de archivo routes/api.php

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MateriaController;

Route::middleware('api')->group(function () {
    // Rutas de Alumnos
    Route::get('/alumnos', [AlumnoController::class, 'index']);
    Route::get('/alumnos/{id}', [AlumnoController::class, 'show']);
    Route::get('/alumnos/{id}/materias', [AlumnoController::class, 'materiasAlumno']);
    Route::post('/alumnos/{alumno_id}/materias/{materia_id}', [AlumnoController::class, 'asignarMateria']);
    Route::delete('/alumnos/{alumno_id}/materias/{materia_id}', [AlumnoController::class, 'desasignarMateria']);
    Route::put('/alumnos/{alumno_id}/materias/{materia_id}/calificacion/{calificacion}', [AlumnoController::class, 'actualizarCalificacion']);

    // Rutas de Materias
    Route::get('/materias', [MateriaController::class, 'index']);
    Route::get('/materias/{id}', [MateriaController::class, 'show']);
    Route::get('/materias/{id}/alumnos', [MateriaController::class, 'alumnosMateria']);
    Route::get('/materias/creditos/{creditos}', [MateriaController::class, 'materiasPorCreditos']);
    Route::get('/materias/{id}/sin-alumnos', [MateriaController::class, 'alumnosSinMateria']);
});
```

---

## Operaciones Básicas desde Tinker

```php
php artisan tinker

// Ver todos los alumnos
$alumnos = App\Models\Alumno::all();

// Ver un alumno con sus materias
$alumno = App\Models\Alumno::with('materias')->first();

// Recorrer las materias de un alumno
foreach ($alumno->materias as $materia) {
    echo $materia->nombre_materia;
}

// Ver todos los alumnos de una materia
$materia = App\Models\Materia::with('alumnos')->first();

// Contar cuántas materias tiene un alumno
$alumno->materias()->count();

// Contar cuántos alumnos tienen una materia
$materia->alumnos()->count();

// Asignar una materia a un alumno
$alumno->materias()->attach(1); // Adjunta la materia con ID 1

// Desasignar una materia
$alumno->materias()->detach(1); // Detacha la materia con ID 1

// Remplazo de todas las materias (sync)
$alumno->materias()->sync([1, 2, 3]); // Solo estas 3 materias

// Actualizar calificación
$alumno->materias()->updateExistingPivot(1, ['calificacion' => '9.5']);

// Buscar alumnos que cursan una materia específica
$alumnos = App\Models\Alumno::whereHas('materias', function ($q) {
    $q->where('nombre_materia', 'Programación');
})->get();

// Buscar materias que NO censa un alumno
$materias = App\Models\Materia::whereDoesntHave('alumnos', function ($q) use ($alumnoId) {
    $q->where('alumno_id', $alumnoId);
})->get();
```

---

## Relaciones Many-to-Many

### En el modelo Alumno:
```php
public function materias()
{
    return $this->belongsToMany(Materia::class, 'alumno_materia', 'alumno_id', 'materia_id')
                ->withPivot('calificacion')
                ->withTimestamps();
}
```

### En el modelo Materia:
```php
public function alumnos()
{
    return $this->belongsToMany(Alumno::class, 'alumno_materia', 'materia_id', 'alumno_id')
                ->withPivot('calificacion')
                ->withTimestamps();
}
```

---

## Tabla Pivot (alumno_materia)

| id | alumno_id | materia_id | calificacion | created_at | updated_at |
|----|-----------|-----------|--------------|------------|------------|
| 1  | 1         | 1         | NULL         | ...        | ...        |
| 2  | 1         | 2         | NULL         | ...        | ...        |
| 3  | 1         | 3         | NULL         | ...        | ...        |
| ... | ... | ... | ... | ... | ... |
