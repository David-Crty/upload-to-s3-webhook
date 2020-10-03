FROM php:7.4-cli

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy app files
COPY . /app

# Build the phar and add it /usr/local/bin
RUN cd /app && composer install && \
  composer run compile && \
  chmod +x ./upload-to-s3-webhook.phar && \
  mv ./upload-to-s3-webhook.phar /usr/local/bin/upload-to-s3-webhook

CMD ["upload-to-s3-webhook"]