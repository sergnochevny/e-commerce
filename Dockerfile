FROM php:7.0-apache
MAINTAINER "Andriy Shendrikov" <ashendrikov@engineering.ait.com>
ENV LC_ALL="C.UTF-8" DEBIAN_FRONTEND="noninteractive"

WORKDIR /

RUN set -x \
  && apt-get update -qq \
  && apt-get upgrade -y \
  && apt-get install --assume-yes --force-yes \
  apt-utils \
  apt-transport-https \
  curl \
  openssh-client \
  libcurl3-dev \
  libicu-dev \
  iputils-ping \
  git \
  libpng-dev \
  npm \
  libbz2-dev \
  libxml2-dev \
  libssl-dev \
  libxslt-dev \
  libedit-dev \
  mysql-client \
  wget \
  && /usr/bin/curl -sS https://getcomposer.org/installer |php \
  && /bin/mv composer.phar /usr/local/bin/composer \
  && npm install bower gulp yarn -g \
  && /usr/sbin/a2enmod rewrite expires setenvif \
  && /usr/sbin/a2dissite '*' \
  && ln -sfT /dev/stderr "/var/log/apache2/error.log" \
  && ln -sfT /dev/stdout "/var/log/apache2/access.log" \
  && ln -sfT /dev/stdout "/var/log/apache2/other_vhosts_access.log" \
  && apt-get clean \
  && apt-get autoremove -y \
  && rm -fr /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/apt/archives/*.deb

RUN set -x \
  && /usr/local/bin/docker-php-ext-install zip pdo pdo_mysql opcache curl gd intl bz2 xml xsl xmlrpc readline

USER root
ADD deploy/docker/app.conf /etc/apache2/sites-enabled/000-app.conf
ADD deploy/docker/docker-entrypoint.sh /docker-entrypoint.sh

COPY . /app

RUN set -x \
  && /bin/chown -R www-data:www-data /app \
  && chmod +x /docker-entrypoint.sh

WORKDIR /app

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
