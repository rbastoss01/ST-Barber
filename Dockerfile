FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache

COPY . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]