# FixFlow — Resumen Técnico de Transferencia

> **Documento para:** Colaborador experto entrante  
> **Preparado por:** Senior Lead Developer  
> **Fecha:** Abril 2026  
> **Confidencialidad:** Interna del equipo

---

## 1. Stack Tecnológico

| Capa | Tecnología | Versión |
|---|---|---|
| Runtime | **PHP** | `^8.2` |
| Framework | **Laravel** | `^12.0` |
| Autenticación | **Laravel Breeze** | `^2.4` (Blade stack) |
| ORM | **Eloquent** (incluido en Laravel) | — |
| Base de datos | **MySQL 8+** / MariaDB | motor InnoDB, charset `utf8mb4` |
| Frontend bundler | **Vite** | `^7.0.7` |
| CSS framework | **Tailwind CSS** | `^3.1.0` (instalado, pendiente de aplicar) |
| JS reactivity | **Alpine.js** | `^3.4.2` |
| HTTP client JS | **Axios** | `^1.11.0` |
| Queue/Jobs | **Laravel Queues** | driver `database` |
| Scheduler | **Laravel Task Scheduling** | via `routes/console.php` |
| Notificaciones | **Laravel Notifications** | canal `database` |
| Email | **Laravel Mail** | driver `log` (dev) / SMTP (prod) |

> **Dev:** El comando `composer run dev` levanta en paralelo: `php artisan serve`, `php artisan queue:listen`, `php artisan pail` y `npm run dev` mediante `concurrently`.

---

## 2. Arquitectura SaaS — Multi-Tenancy

### Estrategia: Shared Database, Shared Schema (columna discriminadora)

FixFlow usa el modelo más común de SaaS de bajo costo: **una sola base de datos** con todas las tablas compartidas, aislando los datos de cada taller mediante una columna `taller_id` presente en **todas las tablas de dominio**.

**No se usan** esquemas separados por tenant ni bases de datos independientes.

### Cómo funciona el aislamiento

```
Registro → Se crea un Taller nuevo → Usuario admin queda ligado a ese Taller
                                         ↓
                              taller_id propagado a todas las entidades
```

1. Cuando un usuario se registra en `/register`, el `RegisteredUserController` **crea automáticamente un registro en la tabla `talleres`** y asocia al usuario como `rol = admin` de ese taller.
2. Cada query de dominio lleva un scope de taller:
   ```php
   // Scope local en el modelo Reparacion
   public function scopeDelTaller($query, int $tallerId)
   {
       return $query->where('taller_id', $tallerId);
   }
   ```
3. Los controladores extraen el taller del usuario autenticado:
   ```php
   $tallerId = auth()->user()->taller_id;
   Reparacion::delTaller($tallerId)->activas()->get();
   ```
4. Toda acción de escritura/lectura sobre modelos ajenos al taller retorna **`abort(403)`** mediante guards en cada controller.

> ⚠️ **Gotcha conocido:** PHP/MySQL puede devolver `taller_id` como `string` desde PDO. Todos los guards de autorización usan cast explícito `(int)` para evitar falsos 403 por comparación estricta `!==`.

---

## 3. Esquema de Base de Datos

### Diagrama de relaciones

```
talleres ──┬──< users
           ├──< clientes ──< reparaciones >── niveles_reparacion
           └──< reparaciones >── escalamientos
                              └──< mensajes
```

### Tablas principales

#### `talleres`
| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | Auto-increment |
| `nombre` | VARCHAR | Nombre del taller |
| `telefono` | VARCHAR | nullable |
| `direccion` | VARCHAR | nullable |
| `suscripcion_activa` | BOOLEAN | Control SaaS de acceso |
| `created_at / updated_at` | TIMESTAMP | — |

#### `users`
| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | — |
| `taller_id` | BIGINT FK | → `talleres.id`, nullable, cascadeOnDelete |
| `name` | VARCHAR | — |
| `email` | VARCHAR UNIQUE | — |
| `password` | VARCHAR | bcrypt hash |
| `rol` | VARCHAR | `admin` o `tecnico` |
| `email_verified_at` | TIMESTAMP | nullable |

#### `clientes`
| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | — |
| `taller_id` | BIGINT FK | → `talleres.id` |
| `nombre` | VARCHAR | — |
| `telefono` | VARCHAR | nullable |
| `email` | VARCHAR | nullable — usado para notificación de equipo listo |
| `direccion` | TEXT | nullable |

#### `niveles_reparacion`
| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | — |
| `nivel` | TINYINT | 1 al 5 |
| `nombre` | VARCHAR | Básico / Menor / Intermedio / Avanzado / Crítico |
| `descripcion` | TEXT | Descripción del tipo de trabajo |
| `horas_sla` | INTEGER | Tiempo máximo de entrega en horas |

#### `reparaciones` ← tabla central del sistema
| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | — |
| `taller_id` | BIGINT FK | → `talleres.id`, cascadeOnDelete |
| `cliente_id` | BIGINT FK | → `clientes.id`, cascadeOnDelete |
| `user_id` | BIGINT FK | → `users.id`, nullOnDelete (técnico asignado) |
| `nivel_id` | BIGINT FK | → `niveles_reparacion.id`, restrictOnDelete |
| `folio` | VARCHAR UNIQUE | Formato `FF-YYYY-NNNN` |
| `token_seguimiento` | VARCHAR UNIQUE | 32 chars random, portal público |
| `tipo_equipo` | VARCHAR | Celular / Laptop / Tablet / etc. |
| `marca` | VARCHAR | — |
| `modelo` | VARCHAR | — |
| `numero_serie` | VARCHAR | nullable |
| `problema_reportado` | TEXT | Ingresado en admisión |
| `diagnostico_tecnico` | TEXT | nullable, llenado por el técnico |
| `comentario_retardo` | TEXT | nullable, justificación del retardo |
| `estado` | ENUM | Ver ciclo de vida §5 |
| `costo_estimado` | DECIMAL(10,2) | nullable |
| `costo_final` | DECIMAL(10,2) | nullable |
| `hora_ingreso` | TIMESTAMP | nullable, se establece al crear |
| `hora_limite` | TIMESTAMP | nullable, `hora_ingreso + horas_sla` |
| `hora_fin` | TIMESTAMP | nullable, se registra al marcar Reparado |

#### `mensajes`
Comunicación bidireccional técnico ↔ cliente por orden.

| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | — |
| `reparacion_id` | BIGINT FK | → `reparaciones.id` |
| `user_id` | BIGINT FK | nullable → `users.id` (null = mensaje del cliente) |
| `contenido` | TEXT | — |
| `es_del_cliente` | BOOLEAN | `true` = enviado desde el portal público |

#### `escalamientos`
Auditoría de cambios de nivel en una reparación.

| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | — |
| `reparacion_id` | BIGINT FK | → `reparaciones.id` |
| `user_id` | BIGINT FK | → `users.id` (quién escaló) |
| `nivel_anterior_id` | BIGINT FK | → `niveles_reparacion.id` |
| `nivel_nuevo_id` | BIGINT FK | → `niveles_reparacion.id` |
| `motivo` | TEXT | Obligatorio, mínimo 10 chars |

#### `notifications` (Laravel nativa)
Alertas de retardo almacenadas en BD para el admin.

#### `jobs` / `cache` / `sessions`
Tablas de infraestructura Laravel, driver `database`.

---

## 4. Lógica de Negocio — SLA y Retardos

### Matriz de niveles de complejidad

| Nivel | Nombre | Tipo de trabajo | SLA (horas) | SLA (días aprox.) |
|---|---|---|---|---|
| **1** | Básico | Mantenimiento preventivo, limpieza, configuración software | **2h** | ~2 horas |
| **2** | Menor | Cambio de periféricos (baterías, pantallas, teclados) sin soldadura | **5h** | ~medio día |
| **3** | Intermedio | Puertos de carga, humedad leve, soldadura básica | **24h** | 1 día |
| **4** | Avanzado | Microsoldadura, reballing, fallas de encendido complejas | **72h** | 3 días |
| **5** | Crítico | Recuperación de datos, corto circuito severo, piezas de importación | **120h** | 5 días |

### Cálculo del SLA al crear una orden

```php
// ReparacionController::store()
$nivel       = NivelReparacion::findOrFail($data['nivel_id']);
$horaIngreso = now();
$horaLimite  = now()->addHours($nivel->horas_sla);

Reparacion::create([
    'hora_ingreso' => $horaIngreso,
    'hora_limite'  => $horaLimite,
    // ...
]);
```

### Recalculo al escalar de nivel

Cuando el técnico detecta un problema mayor y escala el nivel:

```php
// ReparacionController::escalar()
$reparacion->update([
    'nivel_id'    => $nivelNuevo->id,
    'hora_limite' => $reparacion->hora_ingreso->addHours($nivelNuevo->horas_sla),
]);
// El SLA se recalcula desde hora_ingreso ORIGINAL, no desde el momento del escalamiento
```

### Detección automática de Retardos

**Job:** `App\Jobs\VerificarRetardosJob` — implementa `ShouldQueue`  
**Frecuencia:** cada 15 minutos (scheduler en `routes/console.php`)

```
Scheduler (cada 15 min)
    └─→ VerificarRetardosJob::handle()
            └─→ SELECT reparaciones WHERE activas AND estado != 'Retardo' AND hora_limite < NOW()
                    └─→ Por cada resultado:
                          1. UPDATE estado = 'Retardo'
                          2. FIND admin del mismo taller_id
                          3. $admin->notify(new RetardoAdminNotification($reparacion))
                                └─→ INSERT en tabla notifications (canal database)
```

**Activación del scheduler en producción:**
```bash
# Agregar al cron del servidor:
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

> **Nota:** El queue worker también debe estar corriendo: `php artisan queue:listen`.

---

## 5. Flujo de Estados de una Reparación

```
[ADMISIÓN]
    Recibido ──────────────────────────────────────────────────────→ Cancelado
        │
        ↓ (técnico inicia diagnóstico)
    En Revisión
        │                    │
        │                    ↓ (falta de pieza)
        │               Esperando Pieza
        │                    │
        │◄───────────────────┘
        │
        ↓ (scheduler detecta hora_limite < now())
    Retardo  ←──────────────────────── (automático, desde cualquier estado activo)
        │    (técnico puede seguir trabajando)
        │
        ↓ (técnico marca como terminado)
    Reparado ──→ [se registra hora_fin] ──→ [se envía email al cliente si tiene email]
        │
        ↓ (cliente recoge)
    Entregado
```

### Reglas de transición notables

| Desde | Hacia | Acción del sistema |
|---|---|---|
| Cualquier estado activo | `Retardo` | Automático por `VerificarRetardosJob`. Notifica al admin. |
| Cualquier estado | `Reparado` | Registra `hora_fin = now()`. Envía `ReparacionListaMail` al cliente. |
| Cualquier estado | `Cancelado` | Transición manual. No tiene efectos secundarios automáticos. |
| Cualquier nivel | Nivel superior/inferior | Registra en `escalamientos`. Recalcula `hora_limite`. |

---

## 6. Estado del Frontend

### Lo que existe

- **Vite** configurado y operativo como bundler (`vite.config.js`)
- **Tailwind CSS v3** y **Alpine.js** instalados via npm
- El plugin `@tailwindcss/vite` y `@tailwindcss/forms` están disponibles
- **Laravel Breeze** provee el scaffolding de autenticación con sus componentes Blade (`x-input-label`, `x-text-input`, `x-primary-button`, etc.) en `resources/views/components/`

### Estado de las vistas

Todas las vistas están escritas en **HTML semántico puro, sin clases CSS**. Esta decisión fue intencional — el diseñador del equipo aplicará Tailwind sobre esta base.

| Ruta | Vista | Estado |
|---|---|---|
| `/centro-de-mando` | `panel-tecnico.blade.php` | ✅ Estructura completa |
| `/reparaciones` | `reparaciones/index.blade.php` | ✅ Tabla paginada |
| `/reparaciones/create` | `reparaciones/create.blade.php` | ✅ Formulario completo |
| `/reparaciones/{id}` | `reparaciones/show.blade.php` | ✅ Ficha + escalamiento + chat |
| `/seguimiento/{token}` | `seguimiento/show.blade.php` | ✅ Portal público cliente |
| `/clientes` | `clientes/index.blade.php` | ✅ Tabla paginada |
| `/clientes/create` | `clientes/create.blade.php` | ✅ Formulario |
| `/clientes/{id}` | `clientes/show.blade.php` | ✅ Historial |
| `/tecnicos` | `tecnicos/index.blade.php` | ✅ Solo visible para admin |
| `/tecnicos/create` | `tecnicos/create.blade.php` | ✅ Formulario |
| Layout base | `plantillas/base.blade.php` | ✅ Sidebar + header + badge notificaciones |
| Email cliente | `emails/reparacion-lista.blade.php` | ✅ Template HTML |

### Para el diseñador

El layout base en `plantillas/base.blade.php` usa `@vite(['resources/css/app.css', 'resources/js/app.js'])`. Puedes definir todo el sistema de diseño en `resources/css/app.css` con las directivas de Tailwind.

El chat usa **polling JS puro** (`setInterval` cada 5 segundos) — no requiere WebSockets ni librerías adicionales.

---

## 7. Infraestructura de Notificaciones y Background Jobs

### Cola de trabajos

```
QUEUE_CONNECTION=database
```

Las jobs se almacenan en la tabla `jobs`. El worker procesa:
```bash
php artisan queue:listen --tries=1 --timeout=0
```

### Flujo de notificaciones al admin

```
VerificarRetardosJob
    → RetardoAdminNotification (canal: database)
        → INSERT en tabla notifications
            → Visible en /centro-de-mando (badge + lista)
                → Admin puede marcar como leída via NotificacionController
```

### Email al cliente

```
ReparacionController::update() → estado = 'Reparado'
    → Mail::to($cliente->email)->send(new ReparacionListaMail($reparacion))
        → Vista: emails/reparacion-lista.blade.php
        → Incluye: folio, equipo, nombre del taller, URL de seguimiento
```

> **En desarrollo:** `MAIL_MAILER=log` → los emails se escriben en `storage/logs/laravel.log`.  
> **En producción:** Configurar SMTP real (Mailgun, SES, Resend, etc.) en `.env`.

---

## Apéndice — Rutas registradas

```
GET     /                                   Welcome page
GET     /seguimiento/{token}                Portal público del cliente (sin auth)
POST    /seguimiento/{token}/mensaje        Cliente envía mensaje
GET     /seguimiento/{token}/mensajes       Polling JSON de mensajes

GET     /centro-de-mando                    Dashboard (auth)
GET     /reparaciones                       Listado (auth)
GET     /reparaciones/create                Formulario nueva orden (auth)
POST    /reparaciones                       Guardar nueva orden (auth)
GET     /reparaciones/{reparacion}          Detalle de orden (auth)
PATCH   /reparaciones/{reparacion}          Actualizar estado/datos (auth)
POST    /reparaciones/{reparacion}/escalar  Escalar nivel (auth)
GET     /reparaciones/{reparacion}/mensajes Chat JSON (auth)
POST    /reparaciones/{reparacion}/mensajes Enviar mensaje técnico (auth)

GET     /clientes                           Listado (auth)
GET     /clientes/create                    Crear cliente (auth)
POST    /clientes                           Guardar cliente (auth)
GET     /clientes/{cliente}                 Historial del cliente (auth)

GET     /tecnicos                           Listado técnicos — solo admin (auth)
GET     /tecnicos/create                    Crear técnico — solo admin (auth)
POST    /tecnicos                           Guardar técnico — solo admin (auth)
DELETE  /tecnicos/{tecnico}                 Eliminar técnico — solo admin (auth)

POST    /notificaciones/{id}/leida          Marcar notificación leída (auth)
POST    /notificaciones/leer-todas          Marcar todas leídas (auth)

GET     /register                           Registro (crea Taller nuevo)
GET     /login                              Login
POST    /logout                             Logout
```

---

> **Gotchas a tener en cuenta al desarrollar:**
> 1. Los modelos con nombre español NO siguen la pluralización inglesa de Laravel. Se debe declarar `protected $table` explícitamente en `Taller` (`talleres`) y `Reparacion` (`reparaciones`).
> 2. Los resource routes de nombres en español requieren `->parameters([...])` para que el route model binding funcione correctamente.
> 3. La zona horaria del sistema es `America/Mexico_City` — configurada en `.env` como `APP_TIMEZONE`.
