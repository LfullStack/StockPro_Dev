# Etapa 1: Build de frontend con Node.js
FROM node:20 as nodebuilder

WORKDIR /app

# Copia los archivos necesarios
COPY package*.json vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
COPY public/ public/

# Instala dependencias de Node y construye assets
RUN npm install
RUN npm run build

# Etapa 2: PHP con Composer y extensiones
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libpq-dev libxml2-dev zip libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd bcmath mbstring zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copia el proyecto Laravel completo
COPY . .

# Copia los assets generados por Vite
COPY --from=nodebuilder /app/public/build public/build

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Instala dependencias PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Configuración Laravel
RUN cp .env.example .env
RUN php artisan key:generate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
