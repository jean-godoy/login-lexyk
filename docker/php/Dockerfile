FROM ubuntu:20.04 as base

RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y tzdata && apt-get install -y --allow-unauthenticated \
	ubuntu-release-upgrader-core python3-distupgrade apt-utils supervisor wget vim curl nano git unzip jq apt-transport-https ca-certificates software-properties-common zlib1g-dev libxml2-dev ntp \
	acl

RUN DEBIAN_FRONTEND=noninteractive add-apt-repository ppa:ondrej/php -y  && apt-get install -y --allow-unauthenticated \
	php7.4 php7.4-fpm php7.4-cli php7.4-common php7.4-dev php7.4-xdebug \
    php7.4-curl php7.4-soap php7.4-gd php7.4-json php7.4-mbstring php7.4-intl php7.4-xml php7.4-zip \
    php7.4-bcmath php7.4-mysql php7.4-pgsql php7.4-apc php7.4-amqp php-memcached libaio1 ghostscript \
    php7.4-ldap

RUN DEBIAN_FRONTEND=noninteractive apt-get remove apache2

# mcrypt
RUN apt-get install -y libmcrypt-dev && \
pecl install mcrypt-1.0.3
RUN echo "extension=mcrypt.so" >> /etc/php/7.4/cli/php.ini

RUN echo "memory_limit=-1" >> /etc/php/7.4/cli/php.ini
RUN echo "max_execution_time=9999" >> /etc/php/7.4/cli/php.ini
RUN echo "max_input_time=-1" >> /etc/php/7.4/cli/php.ini
#RUN echo "xdebug.remote_enable=on" >> /etc/php/7.4/cli/php.ini
#RUN echo "xdebug.remote_handler=dbgp" >> /etc/php/7.4/cli/php.ini
#RUN echo "xdebug.remote_port=9000" >> /etc/php/7.4/cli/php.ini
#RUN echo "xdebug.remote_autostart=on" >> /etc/php/7.4/cli/php.ini
#RUN echo "xdebug.remote_connect_back=0" >> /etc/php/7.4/cli/php.ini
#RUN echo "xdebug.idekey=docker" >> /etc/php/7.4/cli/php.ini
RUN echo "short_open_tag=off" >> /etc/php/7.4/cli/php.ini
RUN echo "date.timezone=America/Sao_Paulo" >> /etc/php/7.4/cli/php.ini

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY /docker/apache/vhost.config /etc/apache2/sites-available/000-default.conf

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer
RUN composer config --global process-timeout 2000

FROM base as dev

WORKDIR /app

EXPOSE 8000

ENTRYPOINT ["sh", "/app/docker/php/docker-entrypoint.sh"]