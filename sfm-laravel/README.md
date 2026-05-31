# Servicio Fácil Match — Laravel + Vue (Semanas 14–16)

Proyecto migrado al stack del curso **Programación Computacional IV**.

## Stack

- **Laravel 12** — MVC, rutas, controladores, Blade
- **Vue 3** — Composition API (`<script setup>`, `ref`, `v-model`, `v-for`, props)
- **Vite** — compilación de assets
- **Axios** — peticiones HTTP POST/JSON
- **Eloquent + SQLite** — migraciones, modelos, CRUD

## Requisitos

- PHP 8.2+
- Composer
- Node.js 18+

## Instalación

```bash
cd sfm-laravel
composer install
npm install
cp .env.example .env   # si no existe .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Abrir: http://127.0.0.1:8000

Para desarrollo con hot-reload:

```bash
npm run dev
php artisan serve
```

## Rutas por semana

### Semana 14 — MVC + Blade
| Ruta | Descripción |
|------|-------------|
| `/saludo` | Retorna texto plano |
| `/mipagina` | Vista Blade |
| `/mostrarInfo` | Datos con `compact()` |
| `/mostrarCategorias` | Tabla con `@foreach` (arreglo) |
| `/profesionales-arreglo` | Listado desde arreglo |
| `/profesional-arreglo/{id}` | Detalle + `abort(404)` |

### Semana 15 — Vue + Axios
| Ruta | Descripción |
|------|-------------|
| `/calculadora` | Vue 3 + componentes |
| `POST /calcular` | Respuesta JSON |

### Semana 16 — Base de datos
| Ruta | Descripción |
|------|-------------|
| `/` | Listado Eloquent (Blade) |
| `/guardar` | Formulario + inserción POST |
| `/profesionales-vue` | Vue recibe datos vía `@json()` props |

## Documentación

Los PDFs del proyecto (`JUSTIFICACIÓN TECNOLÓGICA SFM.pdf`, `progra 4 avance 2.pdf`) y el script SQL original se conservan en la carpeta raíz como referencia académica.
