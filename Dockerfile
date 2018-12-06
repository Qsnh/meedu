FROM php:7.2-fpm

RUN apt update

# bcmath bz2 calendar ctype curl dba dom enchant exif fileinfo filter ftp gd 
# gettext gmp hash iconv imap interbase intl json ldap mbstring mysqli oci8 
# odbc opcache pcntl pdo pdo_dblib pdo_firebird pdo_mysql pdo_oci pdo_odbc 
# pdo_pgsql pdo_sqlite pgsql phar posix pspell readline recode reflection 
# session shmop simplexml snmp soap sockets sodium spl standard sysvmsg sysvsem 
# sysvshm tidy tokenizer wddx xml xmlreader xmlrpc xmlwriter xsl zend_test zip

RUN apt update \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install ctype \ 
    && apt install -y libfreetype6-dev \
    && apt install -y libjpeg62-turbo-dev \
    && apt install -y libpng-dev \ 
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && apt install -y zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

EXPOSE 9000