FROM php:8.0-apache

# تثبيت امتداد mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# نسخ ملفات التطبيق
COPY . /var/www/html/

EXPOSE 80
