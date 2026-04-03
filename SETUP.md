# FixFlow — Guía de Instalación Local

## Requisitos previos
- PHP 8.2+
- Composer
- Node.js 18+ y npm
- MySQL 8+ (o MariaDB)
- Git

---

## Pasos después de `git clone` / `git pull`

### 1. Instalar dependencias PHP
```bash
composer install
```

### 2. Instalar dependencias JS
```bash
npm install
```

### 3. Crear el archivo de entorno
```bash
cp .env.example .env
```

> ⚠️ El archivo `.env` **no está en git** (está en `.gitignore`). Cada desarrollador tiene su propio `.env` local.

### 4. Generar la clave de aplicación
```bash
php artisan key:generate
```

### 5. Configurar la base de datos

Edita el `.env` y actualiza estas líneas con tus credenciales locales de MySQL:

```env
DB_DATABASE=fixflow
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

Crea la base de datos en MySQL si no existe:
```sql
CREATE DATABASE fixflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Ejecutar migraciones y seeders
```bash
php artisan migrate:fresh --seed
```

Esto crea todas las tablas y carga los datos iniciales:
- 5 niveles de reparación (SLA predefinidos)
- Taller de demostración
- Usuario admin: `admin@fixflow.test` / `password`
- Usuario técnico: `tecnico@fixflow.test` / `password`

### 7. Configurar la zona horaria (México CDMX)

Asegúrate de que en tu `.env` esté:
```env
APP_TIMEZONE=America/Mexico_City
```

---

## Levantar el servidor de desarrollo

Necesitas **dos terminales abiertas**:

**Terminal 1 — Backend:**
```bash
php artisan serve
```

**Terminal 2 — Frontend (Vite):**
```bash
npm run dev
```

Accede en: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Después de cada `git pull`

Si el pull incluye **nuevas migraciones** (archivos en `database/migrations/`):
```bash
php artisan migrate
```

Si el pull incluye **cambios en modelos o configuración**:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Si hay **nuevas dependencias de Composer** (`composer.json` cambió):
```bash
composer install
```

Si hay **nuevas dependencias de npm** (`package.json` cambió):
```bash
npm install
```

---

## Variables de entorno importantes (`.env`)

| Variable | Valor recomendado (local) |
|---|---|
| `APP_NAME` | `FixFlow` |
| `APP_ENV` | `local` |
| `APP_DEBUG` | `true` |
| `APP_TIMEZONE` | `America/Mexico_City` |
| `DB_DATABASE` | `fixflow` |
| `MAIL_MAILER` | `log` (guarda emails en `storage/logs/laravel.log`) |
| `QUEUE_CONNECTION` | `database` |
| `SESSION_DRIVER` | `database` |

---

## Estructura del proyecto

```
app/
├── Http/Controllers/
│   ├── Auth/               ← Autenticación (Breeze)
│   ├── PanelTecnicoController.php
│   ├── ReparacionController.php   ← CRUD + escalamiento + email
│   ├── MensajeController.php      ← Chat JSON
│   ├── SeguimientoController.php  ← Portal público del cliente
│   ├── ClienteController.php
│   ├── TecnicoController.php      ← Gestión de técnicos (admin)
│   └── NotificacionController.php
├── Jobs/
│   └── VerificarRetardosJob.php   ← Scheduler: detecta retardos cada 15min
├── Mail/
│   └── ReparacionListaMail.php    ← Email automático al marcar como Reparado
├── Models/
│   ├── Taller.php
│   ├── User.php (roles: admin / tecnico)
│   ├── Cliente.php
│   ├── Reparacion.php
│   ├── NivelReparacion.php
│   ├── Mensaje.php
│   └── Escalamiento.php
└── Notifications/
    └── RetardoAdminNotification.php
```

---

## Notas para el diseñador (Tailwind)

- Las vistas están en `resources/views/` con **HTML semántico puro** (sin clases CSS).
- El layout base está en `resources/views/plantillas/base.blade.php`.
- Cada vista usa `@extends('plantillas.base')` y `@section('contenido-principal')`.
- Los IDs de elementos interactivos siguen la convención `kebab-case`.
- El chat usa polling JS puro cada 5 segundos (sin necesidad de WebSockets).
