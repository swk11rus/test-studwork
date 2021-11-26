FROM yiisoftware/yii2-php:7.4-apache

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/api/web|g' /etc/apache2/sites-available/000-default.conf
RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev git && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap \
    --with-kerberos \
    --with-imap-ssl
RUN docker-php-ext-install imap
