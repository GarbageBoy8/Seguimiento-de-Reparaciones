# FixBound - Resumen Tecnico de Transferencia

> **Documento para:** Colaborador experto entrante  
> **Preparado por:** Antonio Pareja
> **Actualizado:** Junio 2026  
> **Confidencialidad:** Interna del equipo

---

## 1. Stack Tecnologico

| Capa | Tecnologia | Version / detalle |
|---|---|---|
| Runtime | **PHP** | `^8.2` |
| Framework | **Laravel** | `^12.0` |
| Autenticacion | **Laravel Breeze** | `^2.4`, stack Blade |
| ORM | **Eloquent** | Incluido en Laravel |
| Base de datos | **MySQL 8+ / MariaDB** | InnoDB, `utf8mb4` |
| Frontend bundler | **Vite** | `^7.0.7` |
| CSS framework | **Tailwind CSS** | `^3.1.0`, aplicado en vistas principales |
| JS reactivity | **Alpine.js** | `^3.4.2` |
| HTTP client JS | **Axios** | `^1.11.0` |
| Queue / Jobs | **Laravel Queues** | Driver recomendado: `database` |
| Scheduler | **Laravel Task Scheduling** | Definido en `routes/console.php` |
| Notificaciones | **Laravel Notifications** | Canal `database` |
| Email | **Laravel Mail** | `log` en dev / SMTP en prod |

Comando de desarrollo disponible:

```bash
composer run dev
```

Levanta en paralelo `php artisan serve`, `php artisan queue:listen --tries=1 --timeout=0`, `php artisan pail --timeout=0` y `npm run dev` mediante `concurrently`.

---

## 2. Arquitectura SaaS y Multi-Tenancy

### Estrategia

FixBound usa **shared database, shared schema**: una sola base de datos y tablas compartidas. El aislamiento de datos se hace con `taller_id` en las tablas de dominio.

No se usan bases separadas por tenant ni esquemas independientes.

### Flujo de registro

```
/register
    -> RegisteredUserController::store()
        -> valida taller, codigo_publico, usuario y password
        -> obtiene plan basico
        -> crea taller con trial de 7 dias
        -> crea usuario admin ligado al taller
        -> inicia sesion
        -> redirige a /centro-de-mando
```

El registro crea:

- Un `taller` con `subscription_status = trial`.
- Un `trial_ends_at = now()->addDays(7)`.
- Un `plan_id` apuntando al plan `basico`.
- Un usuario `rol = admin`.

### Aislamiento de datos

El modelo `Reparacion` tiene el scope:

```php
public function scopeDelTaller($query, int $tallerId)
{
    return $query->where('taller_id', $tallerId);
}
```

Los controladores toman el taller desde el usuario autenticado:

```php
$tallerId = auth()->user()->taller_id;
```

Las acciones sobre modelos concretos validan pertenencia al taller con guards tipo:

```php
abort_if((int) $reparacion->taller_id !== (int) auth()->user()->taller_id, 403);
```

**Gotcha importante:** PDO/MySQL puede devolver IDs como string. Por eso los guards usan cast explicito a `(int)` antes de comparar.

---

## 3. Suscripcion, Planes y Acceso

### Planes

La tabla `subscription_plans` define capacidades comerciales del taller:

| Plan | Slug | Max tecnicos | Clientes mayoristas |
|---|---|---:|---|
| Basico | `basico` | 2 | No |
| Pro | `pro` | 4 | No |
| Taller Plus | `taller-plus` | 15 | Si |

Los planes se siembran desde `DatabaseSeeder`.

### Campos relevantes en `talleres`

| Campo | Notas |
|---|---|
| `plan_id` | FK nullable a `subscription_plans` |
| `codigo_publico` | Codigo unico del taller usado en folios globales |
| `trial_ends_at` | Fin de prueba gratuita |
| `subscription_status` | `trial`, `active` u otro estado no activo |
| `subscription_ends_at` | Fin de suscripcion pagada |
| `suscripcion_activa` | Campo heredado; el acceso real usa `suscripcionEstaActiva()` |

### Middleware de acceso

Las rutas autenticadas de negocio usan:

```php
Route::middleware(['auth', 'subscription.active'])->group(...)
```

`EnsureTallerSubscriptionIsActive` obtiene `$request->user()->taller` y llama:

```php
$taller->suscripcionEstaActiva()
```

Reglas actuales:

- `trial`: activo si `trial_ends_at` existe y no ha vencido.
- `active`: activo si `subscription_ends_at` es null o no ha vencido.
- Cualquier otro estado: no activo.

Si no hay acceso, redirige a `billing.expired`.

### Limites por plan

`TecnicoController` valida que solo admins puedan gestionar tecnicos y bloquea creacion cuando:

```php
$taller->tecnicosCount() >= $taller->maxTecnicos()
```

`ClienteController` bloquea `es_mayorista = true` si el plan no permite clientes mayoristas.

---

## 4. Esquema de Base de Datos

### Relaciones principales

```
subscription_plans ──< talleres ──┬──< users
                                  ├──< clientes ──< reparaciones >── niveles_reparacion
                                  └──< reparaciones >── escalamientos
                                                     └──< mensajes
```

### `talleres`

| Campo | Tipo | Notas |
|---|---|---|
| `id` | BIGINT PK | Auto-increment |
| `nombre` | VARCHAR | Nombre del taller |
| `telefono` | VARCHAR | nullable |
| `direccion` | TEXT | nullable |
| `suscripcion_activa` | BOOLEAN | Campo heredado |
| `plan_id` | BIGINT FK | nullable, `nullOnDelete` |
| `codigo_publico` | VARCHAR UNIQUE | Max 20 en BD; normalizado a max 10 en modelo/controlador |
| `trial_ends_at` | TIMESTAMP | nullable |
| `subscription_status` | VARCHAR(30) | default `trial`, indexado |
| `subscription_ends_at` | TIMESTAMP | nullable |

### `subscription_plans`

| Campo | Tipo | Notas |
|---|---|---|
| `nombre` | VARCHAR | Nombre comercial |
| `slug` | VARCHAR UNIQUE | Identificador estable |
| `descripcion` | TEXT | nullable |
| `precio_mensual` | DECIMAL | nullable |
| `max_tecnicos` | SMALLINT | Limite por taller |
| `permite_clientes_mayoristas` | BOOLEAN | Habilita flag en clientes |
| `features` | JSON | Cast a array |
| `activo` | BOOLEAN | Habilita plan |

### `users`

| Campo | Tipo | Notas |
|---|---|---|
| `taller_id` | BIGINT FK | nullable, cascadeOnDelete |
| `name` | VARCHAR | Nombre usuario |
| `email` | VARCHAR UNIQUE | Login |
| `password` | VARCHAR | Hash bcrypt / cast `hashed` |
| `rol` | VARCHAR | `admin` o `tecnico` |
| `email_verified_at` | TIMESTAMP | nullable |

### `clientes`

| Campo | Tipo | Notas |
|---|---|---|
| `taller_id` | BIGINT FK | cascadeOnDelete |
| `nombre` | VARCHAR | requerido |
| `email` | VARCHAR | nullable; usado para correos |
| `telefono` | VARCHAR | nullable |
| `direccion` | TEXT | nullable |
| `es_mayorista` | BOOLEAN | default false, limitado por plan |

### `niveles_reparacion`

| Campo | Tipo | Notas |
|---|---|---|
| `nivel` | TINYINT UNIQUE | 1 al 5 |
| `nombre` | VARCHAR | Basico, Menor, Intermedio, Avanzado, Critico |
| `descripcion` | TEXT | Texto para UI |
| `horas_sla` | INTEGER | Horas maximas de SLA |

### `reparaciones`

Tabla central del sistema.

| Campo | Tipo | Notas |
|---|---|---|
| `taller_id` | BIGINT FK | cascadeOnDelete |
| `cliente_id` | BIGINT FK | cascadeOnDelete |
| `user_id` | BIGINT FK | nullable, `nullOnDelete`; tecnico asignado |
| `nivel_id` | BIGINT FK | `restrictOnDelete` |
| `folio` | VARCHAR UNIQUE | Formato actual: `FF-{CODIGO_TALLER}-{YYYY}-{NNNN}` |
| `token_seguimiento` | VARCHAR UNIQUE | Token publico de 32 caracteres |
| `tipo_equipo` | VARCHAR | Laptop, celular, tablet, etc. |
| `marca` | VARCHAR | requerido |
| `modelo` | VARCHAR | requerido |
| `numero_serie` | VARCHAR | nullable |
| `problema_reportado` | TEXT | Ingreso/admisiones |
| `diagnostico_tecnico` | TEXT | nullable |
| `comentario_retardo` | TEXT | nullable |
| `estado` | ENUM | Ver flujo de estados |
| `costo_estimado` | DECIMAL(10,2) | nullable |
| `costo_final` | DECIMAL(10,2) | nullable |
| `hora_ingreso` | TIMESTAMP | seteada al crear |
| `hora_limite` | TIMESTAMP | `hora_ingreso + horas_sla` |
| `hora_fin` | TIMESTAMP | seteada al marcar `Reparado` |

### `mensajes`

Chat por orden.

| Campo | Notas |
|---|---|
| `reparacion_id` | FK a reparacion |
| `user_id` | nullable; null significa mensaje del cliente |
| `contenido` | Texto, maximo validado 1000 caracteres |
| `es_del_cliente` | true si viene del portal publico |

### `escalamientos`

Auditoria de cambios de nivel.

| Campo | Notas |
|---|---|
| `reparacion_id` | Orden afectada |
| `user_id` | Usuario que escala |
| `nivel_anterior_id` | Nivel previo |
| `nivel_nuevo_id` | Nuevo nivel |
| `motivo` | requerido, minimo 10 caracteres |

### Infraestructura

- `notifications`: notificaciones database de Laravel.
- `jobs`, `failed_jobs`, `job_batches`: queues.
- `cache`, `cache_locks`: cache database.
- `sessions`: sesiones database.
- `password_reset_tokens`: recuperacion de password.

---

## 5. Folios y Seguimiento Publico

### Formato actual de folio

Los folios son globalmente unicos:

```text
FF-{CODIGO_TALLER}-{YYYY}-{NNNN}
```

Ejemplo:

```text
FF-DEMO-2026-0001
```

`Reparacion::generarFolio($tallerId)`:

1. Obtiene el `codigo_publico` del taller.
2. Si no existe, lo genera desde el nombre del taller.
3. Calcula el maximo consecutivo del taller para el anio actual.
4. Devuelve el siguiente folio global.

La migracion mas reciente (`2026_06_03_000003_make_reparacion_folio_globally_unique.php`) migro desde folios unicos por taller a folios globales para permitir rastreo publico solo con folio.

### Codigo publico del taller

`Taller::normalizarCodigoPublico()`:

- Convierte a ASCII.
- Elimina caracteres no alfanumericos.
- Convierte a mayusculas.
- Limita a 10 caracteres.

`Taller::generarCodigoPublico()` evita colisiones agregando sufijos numericos.

### Portal publico

Rutas:

- `GET /rastrear`: formulario publico para capturar folio.
- `POST /rastrear`: normaliza el folio y redirige al seguimiento si existe.
- `GET /seguimiento/{token}`: portal del cliente.
- `POST /seguimiento/{token}/mensaje`: cliente envia mensaje.
- `GET /seguimiento/{token}/mensajes`: polling JSON.

El token sigue siendo la autorizacion real para ver la orden. El folio solo sirve para encontrar y redirigir al token.

---

## 6. Logica de Reparaciones, SLA y Retardos

### Matriz de niveles

| Nivel | Nombre | Tipo de trabajo | SLA |
|---|---|---|---:|
| 1 | Basico | Mantenimiento preventivo, limpieza, configuracion simple | 2h |
| 2 | Menor | Cambio de baterias, pantallas, teclados sin soldadura | 5h |
| 3 | Intermedio | Puertos de carga, humedad leve, soldadura basica | 24h |
| 4 | Avanzado | Microsoldadura, reballing, fallas complejas | 72h |
| 5 | Critico | Recuperacion de datos, corto severo, piezas de importacion | 120h |

### Creacion de orden

`ReparacionController::store()`:

1. Valida cliente existente del mismo taller o datos para crear cliente.
2. Valida nivel, tecnico del mismo taller, equipo, problema y costo.
3. Crea cliente si no se envio `cliente_id`.
4. Calcula `hora_ingreso = now()` y `hora_limite = now()->addHours($nivel->horas_sla)`.
5. Genera folio global y token de seguimiento.
6. Crea orden con estado `Recibido`.
7. Si el cliente tiene email, envia `OrdenCreadaMail`.

### Actualizacion de orden

`ReparacionController::update()` permite:

- Cambiar `estado`.
- Editar diagnostico tecnico.
- Agregar comentario de retardo.
- Actualizar costo final.
- Reasignar tecnico del mismo taller.

Si el estado pasa a `Reparado` y antes no era `Reparado`:

- Setea `hora_fin = now()`.
- Envia `ReparacionListaMail` si el cliente tiene email.

### Escalamiento

`ReparacionController::escalar()`:

1. Valida que el nuevo nivel exista y sea distinto del actual.
2. Exige `motivo` minimo de 10 caracteres.
3. Crea registro en `escalamientos`.
4. Actualiza `nivel_id`.
5. Recalcula `hora_limite` desde `hora_ingreso` original:

```php
'hora_limite' => $reparacion->hora_ingreso->copy()->addHours($nivelNuevo->horas_sla)
```

El `copy()` evita mutar el atributo `hora_ingreso` en memoria.

### Retardos automaticos

`App\Jobs\VerificarRetardosJob` corre cada 15 minutos desde `routes/console.php`.

Busca:

```php
Reparacion::pendientesDeRetardo()
```

El scope excluye `Retardo`, `Reparado`, `Entregado` y `Cancelado`, y filtra `hora_limite < now()`.

Por cada orden:

1. Cambia `estado` a `Retardo`.
2. Busca el admin del mismo taller.
3. Crea `RetardoAdminNotification` en database.

Produccion requiere scheduler y worker:

```bash
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
php artisan queue:listen --tries=1 --timeout=0
```

---

## 7. Flujo de Estados

```text
[ADMISION]
    Recibido ───────────────────────────────────────────────→ Cancelado
        │
        ↓
    En Revision
        │                    │
        │                    ↓
        │               Esperando Pieza
        │                    │
        │◄───────────────────┘
        │
        ↓ automatico si hora_limite < now()
    Retardo
        │
        ↓
    Reparado ──→ set hora_fin + email al cliente
        │
        ↓
    Entregado
```

Reglas relevantes:

| Evento | Efecto |
|---|---|
| Scheduler detecta SLA vencido | `estado = Retardo`, notifica admin |
| Estado cambia a `Reparado` | Setea `hora_fin`, envia `ReparacionListaMail` |
| Estado cambia a `Cancelado` | Sin efectos secundarios |
| Escalamiento de nivel | Audita en `escalamientos`, recalcula SLA |

---

## 8. Controladores Principales

| Controlador | Responsabilidad |
|---|---|
| `PanelTecnicoController` | Dashboard, estadisticas, ordenes activas, notificaciones admin |
| `ReparacionController` | Listado, creacion, detalle, update, escalamiento |
| `SeguimientoController` | Busqueda publica por folio, portal cliente, chat cliente |
| `MensajeController` | Chat JSON autenticado tecnico/admin |
| `ClienteController` | Listado, busqueda, alta, detalle/historial, clientes mayoristas |
| `TecnicoController` | CRUD parcial de tecnicos, solo admin, limites por plan |
| `NotificacionController` | Marcar notificaciones leidas |
| `RegisteredUserController` | Registro SaaS: taller + admin + trial + plan basico |

---

## 9. Frontend

### Estado actual

- Las vistas principales ya usan Tailwind de forma extensa.
- `resources/css/app.css` contiene las directivas base de Tailwind.
- `resources/js/app.js` importa `bootstrap.js`, registra Alpine y ejecuta `Alpine.start()`.
- `plantillas/base.blade.php` es el layout principal autenticado con sidebar, header, colapso persistido en `localStorage` y badge de notificaciones.
- `layouts/guest.blade.php` y vistas Breeze siguen cubriendo autenticacion.

### Componentes Blade relevantes

| Componente | Uso |
|---|---|
| `x-custom-select` | Select buscable/generico |
| `x-tipo-equipo-select` | Selector de tipo de equipo |
| `x-select-tecnico` | Selector de tecnico |
| `x-select-nivel` | Selector de nivel de reparacion |
| `x-order-mobile-card` | Card responsive para ordenes |
| Componentes Breeze | Inputs, botones, dropdowns, modal |

### Vistas clave

| Ruta | Vista | Estado |
|---|---|---|
| `/` | `welcome.blade.php` | Landing publica |
| `/rastrear` | `seguimiento/buscar.blade.php` | Busqueda publica por folio |
| `/seguimiento/{token}` | `seguimiento/show.blade.php` | Portal cliente con chat |
| `/centro-de-mando` | `panel-tecnico.blade.php` | Dashboard autenticado |
| `/reparaciones` | `reparaciones/index.blade.php` | Listado con filtros |
| `/reparaciones/create` | `reparaciones/create.blade.php` | Alta de orden |
| `/reparaciones/{id}` | `reparaciones/show.blade.php` | Ficha, update, escalamiento, chat |
| `/clientes` | `clientes/index.blade.php` | Listado, busqueda, filtro mayoristas |
| `/clientes/create` | `clientes/create.blade.php` | Alta cliente |
| `/clientes/{id}` | `clientes/show.blade.php` | Historial del cliente |
| `/tecnicos` | `tecnicos/index.blade.php` | Solo admin |
| `/tecnicos/create` | `tecnicos/create.blade.php` | Alta tecnico con limite por plan |
| `/suscripcion/vencida` | `billing/expired.blade.php` | Bloqueo por suscripcion |

El chat usa polling JS puro cada 5 segundos. No hay WebSockets.

---

## 10. Emails y Notificaciones

### Emails

| Clase | Evento | Vista |
|---|---|---|
| `OrdenCreadaMail` | Se crea orden y cliente tiene email | `emails.orden-creada` |
| `ReparacionListaMail` | Orden pasa a `Reparado` y cliente tiene email | `emails.reparacion-lista` |

Ambos incluyen la URL de seguimiento:

```php
url("/seguimiento/{$this->reparacion->token_seguimiento}")
```

### Notificaciones

`RetardoAdminNotification` usa canal `database` e incluye:

- `reparacion_id`
- `folio`
- `cliente`
- `equipo`
- `tecnico`
- `nivel`
- `hora_limite`
- `mensaje`

El dashboard muestra notificaciones no leidas solo para admins.

---

## 11. Rutas Registradas Relevantes

Publicas:

```text
GET     /                                   Landing
GET     /rastrear                           Formulario busqueda por folio
POST    /rastrear                           Redireccion a seguimiento por token
GET     /seguimiento/{token}                Portal cliente
POST    /seguimiento/{token}/mensaje        Mensaje cliente
GET     /seguimiento/{token}/mensajes       Polling JSON cliente
```

Autenticadas:

```text
GET     /dashboard                          Alias Breeze -> panel.inicio
GET     /suscripcion/vencida                Pantalla bloqueo suscripcion
GET     /centro-de-mando                    Dashboard

GET     /reparaciones                       Listado
GET     /reparaciones/create                Nueva orden
POST    /reparaciones                       Crear orden
GET     /reparaciones/{reparacion}          Detalle
PATCH   /reparaciones/{reparacion}          Actualizar orden
POST    /reparaciones/{reparacion}/escalar  Escalar nivel
GET     /reparaciones/{reparacion}/mensajes Chat tecnico JSON
POST    /reparaciones/{reparacion}/mensajes Enviar mensaje tecnico

GET     /clientes                           Listado
GET     /clientes/create                    Nuevo cliente
POST    /clientes                           Crear cliente
GET     /clientes/{cliente}                 Historial

GET     /tecnicos                           Listado tecnicos, solo admin
GET     /tecnicos/create                    Nuevo tecnico, solo admin
POST    /tecnicos                           Crear tecnico, solo admin
DELETE  /tecnicos/{tecnico}                 Eliminar tecnico, solo admin

POST    /notificaciones/{id}/leida          Marcar una notificacion leida
POST    /notificaciones/leer-todas          Marcar todas como leidas
```

Autenticacion Breeze:

```text
GET/POST /register
GET/POST /login
POST     /logout
GET/POST /forgot-password
GET/POST /reset-password
GET/POST /confirm-password
PUT      /password
```

---

## 12. Setup Local

Flujo recomendado:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

Variables relevantes:

```env
APP_NAME=FixBound
APP_TIMEZONE=America/Mexico_City
DB_DATABASE=fixbound
QUEUE_CONNECTION=database
SESSION_DRIVER=database
MAIL_MAILER=log
```

Credenciales demo sembradas:

```text
admin@fixbound.test / password
tecnico@fixbound.test / password
```

Nota de pruebas: `phpunit.xml` usa SQLite en memoria (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`). El entorno local necesita la extension PDO SQLite habilitada para correr la suite Feature.

---

## 13. Infraestructura Docker

El repo incluye:

- `Dockerfile` multi-stage.
- `docker-compose.prod.yml`.

Servicios definidos para produccion:

- `fixbound-app`
- `fixbound-worker`
- `fixbound-scheduler`
- `fixbound-mysql`

El worker procesa queue y el scheduler ejecuta `schedule:run`.

---

## 14. Gotchas y Decisiones Importantes

1. Los nombres en espanol no siempre pluralizan como Laravel espera. `Taller` y `Reparacion` declaran `protected $table`.
2. Las rutas resource en espanol usan `->parameters([...])` para que route model binding use el parametro correcto.
3. `folio` volvio a ser globalmente unico desde junio 2026. No asumir folios repetidos por taller.
4. El formato vigente de folio incluye `codigo_publico` del taller.
5. `codigo_publico` es unico en `talleres` y se normaliza en modelo/controlador.
6. El portal publico por token no requiere auth; validar cuidadosamente cualquier dato expuesto alli.
7. `Retardo` puede ser estado manual o automatico, pero el job evita duplicar notificaciones excluyendo ordenes ya en `Retardo`.
8. El acceso por suscripcion depende de `subscription_status`, `trial_ends_at` y `subscription_ends_at`, no solamente de `suscripcion_activa`.
9. Los clientes mayoristas existen, pero solo deben crearse si el plan lo permite.
10. La suite de tests scaffold de Breeze no cubre todavia los flujos propios de reparaciones, suscripcion, folios ni seguimiento publico.
