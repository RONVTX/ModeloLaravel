
## Instalación

Sigue estos pasos para clonar el repositorio e instalar todas las dependencias.

### Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd retrogames
```

### Instalar dependencias

#### Dependencias de PHP

```bash
composer install
```

#### Dependencias de Node.js

```bash
npm install
```

### Configurar el entorno

Copia el archivo de ejemplo del entorno y genera la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

### Ejecutar migraciones

Si el proyecto utiliza una base de datos, ejecuta las migraciones para crear las tablas:

```bash
php artisan migrate
```

### Iniciar la aplicación

#### Servidor de desarrollo de Laravel

```bash
php artisan serve
```

Esto iniciará el servidor en `http://localhost:8000`.

#### Compilar assets (opcional, para desarrollo)

Si necesitas compilar los assets de frontend:

```bash
npm run dev
```
