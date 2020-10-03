FROM php:7.4-cli

RUN apt update &&  apt-get install --yes zip unzip zlib1g-dev libzip-dev
RUN docker-php-ext-install zip
# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy app files
COPY . /app
WORKDIR /app

# Build the phar and add it /usr/local/bin
RUN cd /app && composer install && composer bin box require --dev humbug/box && \
  composer run compile && \
  chmod +x ./upload-to-s3-webhook.phar && \
  mv ./upload-to-s3-webhook.phar /usr/local/bin/upload-to-s3-webhook

CMD ["upload-to-s3-webhook"]