FROM wordpress:6.0.2-php8.0-apache
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# RUN composer init --name abg/phpcs --require squizlabs/php_codesniffer=* --require  wp-coding-standards/wpcs:2.3.0 --require wptrt/wpthemereview:* --require dealerdirect/phpcodesniffer-composer-installer:^0.7  

# RUN echo $' \n\
#   composer init --name abg/phpcs \n\
#   --require squizlabs/php_codesniffer=* \n\
#   --require  wp-coding-standards/wpcs:2.3.0 \n\
#   --require wptrt/wpthemereview:* \n\
#   --require dealerdirect/phpcodesniffer-composer-installer:^0.7 \n\
#   ' 


