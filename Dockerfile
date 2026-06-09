# ============================================================
# FixFlow — Dockerfile multi-stage
# Compatible con ARM64 (Oracle Cloud VM.Standard.A1.Flex)
# ============================================================

# ─── Stage 1: Compilar assets de frontend ───────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copiar sólo los archivos necesarios para instalar y compilar
COPY package.json package-lock.json vite.config.js ./
COPY resources/css/ resources/css/
COPY resources/js/  resources/js/

RUN npm ci && npm run build
# Resultado: /app/public/build/


# ─── Stage 2: Instalar dependencias PHP de producción ────────
FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts
# NOTA: --no-scripts omite package:discover intencionalmente.
# Ese comando, junto con config:cache, route:cache, view:cache y migrate --force,
# se ejecutan como "Deploy Command" en Coolify, donde APP_KEY y DB ya están disponibles.
# Resultado: /app/vendor/


# ─── Stage 3: Imagen de producción ───────────────────────────
FROM php:8.2-fpm-alpine AS final

# ── Variables de entorno no sensibles ──
ENV APP_ENV=production \
    LOG_CHANNEL=stderr

# ── Extensiones PHP del sistema ──
# Descargamos el instalador inteligente oficial de extensiones PHP para Docker
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Damos permisos, instalamos paquetes base de Alpine y usamos el script para PHP
RUN chmod +x /usr/local/bin/install-php-extensions \
    && apk add --no-cache \
    nginx \
    supervisor \
    curl \
    bash \
    && install-php-extensions \
    pdo_mysql \
    mbstring \
    tokenizer \
    xml \
    ctype \
    bcmath \
    fileinfo \
    pcntl \
    opcache

# ── Configuración de Nginx ──
RUN mkdir -p /run/nginx
COPY --chmod=644 <<'EOF' /etc/nginx/http.d/default.conf
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include       fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }
}
EOF

# ── Configuración de Supervisord ──
COPY --chmod=644 <<'EOF' /etc/supervisord.conf
[supervisord]
nodaemon=true
logfile=/dev/null
logfile_maxbytes=0
pidfile=/run/supervisord.pid

[program:php-fpm]
command=php-fpm -F
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0

[program:nginx]
command=nginx -g "daemon off;"
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
EOF

# ── Código de la aplicación ──
WORKDIR /var/www/html

# Copiar código fuente (sin node_modules, .env, etc. — ver .dockerignore)
COPY . .

# Copiar vendor/ desde el stage composer-builder
COPY --from=composer-builder /app/vendor ./vendor

# Copiar assets compilados desde el stage node-builder
COPY --from=node-builder /app/public/build ./public/build

# ── Permisos de directorios que Laravel necesita escribir ──
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN echo "opcache.enable=1\nopcache.memory_consumption=128\nopcache.validate_timestamps=0" \
    > /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
