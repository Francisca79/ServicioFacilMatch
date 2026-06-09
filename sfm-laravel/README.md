# Servicio Fácil Match (SFM)

Plataforma web desarrollada para conectar **clientes** con **profesionales de servicios** en **San Miguel, El Salvador**. Permite explorar perfiles por categoría y zona, enviar solicitudes de servicio, conversar por mensajería, gestionar cobros en efectivo, publicar reseñas y administrar el sistema desde un panel de moderación.

**Tecnologías principales:** Laravel 12 · Blade · Tailwind CSS · Vite · Laravel Sanctum · PHPUnit

**Código fuente de la aplicación:** `ServicioFacilMatch/sfm-laravel/`

---

## Integrantes del grupo

| # | Nombre completo | Código de estudiante |
|---|-----------------|----------------------|
| 1 | _Madeline Brunella Mejia Mejia | _SMSS063924_ |
| 2 | _ _ | _ _ |
| 3 | _ _ | _ _ |

---

## Gestor de base de datos

El proyecto utiliza **SQLite** como motor de base de datos.

- Archivo de la base de datos: `ServicioFacilMatch/sfm-laravel/database/database.sqlite`
- Configuración en `.env`: `DB_CONNECTION=sqlite`
- La estructura se define mediante **migraciones de Laravel** en `database/migrations/`
- Los datos de prueba se cargan con el seeder `SfmSeeder`

---

## Requisitos previos

- **PHP** 8.2 o superior (extensiones: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`)
- **Composer** 2.x
- **Node.js** 18+ y **npm**
- **Git** (opcional, para clonar el repositorio)

---

## Instalación

### 1. Clonar o descargar el repositorio

```bash
git clone <url-del-repositorio>
cd SFM-Parcial
```

### 2. Instalar dependencias de PHP

```bash
cd ServicioFacilMatch/sfm-laravel
composer install
```

### 3. Configurar el entorno

```bash
copy .env.example .env
php artisan key:generate
```

En Windows PowerShell también puedes usar:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Verifica que en `.env` figure:

```env
DB_CONNECTION=sqlite
```

### 4. Crear la base de datos y cargar datos

```bash
# Si no existe el archivo SQLite, créalo:
# Windows (PowerShell):
New-Item -ItemType File -Path database\database.sqlite -Force

php artisan migrate --seed
php artisan storage:link
```

### 5. Instalar dependencias frontend y compilar assets

```bash
npm install
npm run build
```

Para desarrollo con recarga automática de estilos y scripts:

```bash
npm run dev
```

### 6. Iniciar el servidor

```bash
php artisan serve
```

Abre en el navegador: **http://127.0.0.1:8000**

---

## Credenciales de prueba

| Rol | Correo | Contraseña |
|-----|--------|------------|
| Administrador | admin@sfm.com | 123456 |
| Cliente | franciscabon233@gmail.com | 123456 |
| Profesional | carlos@sfm.com | 123456 |

---

## Estructura del repositorio

```
SFM-Parcial/
├── README.md                          ← Este archivo
└── ServicioFacilMatch/
    ├── DOCUMENTO_PRESENTACION_SFM.md  ← Guía de presentación del proyecto
    └── sfm-laravel/                   ← Aplicación Laravel
        ├── app/                       ← Controladores, modelos, validaciones
        ├── database/                  ← Migraciones, seeders y SQLite
        ├── resources/views/           ← Vistas Blade
        ├── routes/                    ← Rutas web y API
        └── public/                    ← Punto de entrada público
```

---

## Comandos útiles

```bash
# Ejecutar pruebas automatizadas
php artisan test

# Reiniciar base de datos con datos de prueba
php artisan migrate:fresh --seed

# Limpiar caché de la aplicación
php artisan optimize:clear
```

---

## Módulos principales

- **Público:** inicio, listado de profesionales, categorías y reseñas públicas.
- **Cliente:** explorar profesionales, mensajería, solicitudes de servicio, reseñas y perfil.
- **Profesional:** perfil, mensajería, aceptar/rechazar solicitudes, confirmar cobros e ingresos.
- **Administrador:** usuarios, clientes, profesionales, reseñas, advertencias, pagos y reportes.

---



