FROM phpdockerio/php:8.0-fpm
WORKDIR "/application"

ARG DEBIAN_FRONTEND=noninteractive
ARG USER_ID=1000
ARG GROUP_ID=1000


RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        php8.0-amqp \
        php8.0-ast \
        php8.0-bcmath \
        php8.0-bz2 \
        php8.0-cgi \
        php8.0-dba \
        php8.0-decimal \
        php8.0-ds \
        php8.0-enchant \
        php8.0-gd \
        php8.0-gearman \
        php8.0-gmagick \
        php8.0-gmp \
        php8.0-gnupg \
        php8.0-grpc \
        php8.0-http \
        php8.0-igbinary \
        php8.0-imagick \
        php8.0-imap \
        php8.0-inotify \
        php8.0-interbase \
        php8.0-intl \
        php8.0-ldap \
        php8.0-lz4 \
        php8.0-mailparse \
        php8.0-maxminddb \
        php8.0-mcrypt \
        php8.0-memcache \
        php8.0-memcached \
        php8.0-mongodb \
        php8.0-msgpack \
        php8.0-mysql \
        php-mysql \
        php8.0-oauth \
        php8.0-odbc \
        php8.0-pcov \
        php8.0-pgsql \
        php8.0-phpdbg \
        php8.0-protobuf \
        php8.0-pspell \
        php8.0-psr \
        php8.0-raphf \
        php8.0-redis \
        php8.0-rrd \
        php8.0-smbclient \
        php8.0-snmp \
        php8.0-soap \
        php8.0-solr \
        php8.0-sqlite3 \
        php8.0-ssh2 \
        php8.0-swoole \
        php8.0-sybase \
        php8.0-tidy \
        php8.0-uuid \
        php8.0-vips \
        php8.0-xdebug \
        php8.0-xhprof \
        php8.0-xmlrpc \
        php8.0-xsl \
        php8.0-yac \
        php8.0-yaml \
        php8.0-zmq \
        php8.0-zstd; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


