FROM php:8.2-cli
LABEL authors="Daria Hrebonkina"

# Install required dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

COPY . /var/www/html
