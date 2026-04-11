# Usar a imagem oficial do PHP com Apache
FROM php:8.4-apache

# Instalar dependências do sistema e bibliotecas necessárias para o Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Limpar o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar as extensões do PHP requeridas pelo Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar e habilitar a extensão do Redis no PHP  <--- ADICIONE ESTAS DUAS LINHAS
RUN pecl install redis && docker-php-ext-enable redis

# Habilitar o mod_rewrite do Apache (necessário para as rotas do Laravel)
RUN a2enmod rewrite

# Alterar o DocumentRoot do Apache para a pasta /public do Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Obter a versão mais recente do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o container
COPY . .

# Instalar as dependências do PHP (sem pacotes de dev)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Instalar as dependências do frontend e fazer o build (Vite/Tailwind)
RUN npm install && npm run build

# Ajustar as permissões das pastas que o Laravel precisa escrever
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Opcional: Script para rodar cache e migrações quando o container iniciar
# RUN echo "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && apache2-foreground" > /usr/local/bin/start.sh
# RUN chmod +x /usr/local/bin/start.sh
# CMD ["/usr/local/bin/start.sh"]

EXPOSE 80