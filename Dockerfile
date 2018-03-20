FROM php:7.0-apache AS build
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
  npm \
  libfreetype6-dev \
  libpng-dev \
  libjpeg-dev \
  zlib1g-dev \
  libbz2-dev \
  libxml2-dev \
  libxpm-dev \
  libssl-dev \
  libxslt-dev \
  libedit-dev \
  mysql-client \
  imagemagick \
  graphicsmagick \
  wget \
  && /usr/bin/curl -sS https://getcomposer.org/installer |php \
  && /bin/mv composer.phar /usr/local/bin/composer \
  && npm install bower gulp yarn -g \
  && /usr/sbin/a2enmod rewrite expires setenvif \
  && /usr/sbin/a2dissite '*' \
  && ln -sfT /dev/stderr "/var/log/apache2/error.log" \
  && ln -sfT /dev/stdout "/var/log/apache2/access.log" \
  && ln -sfT /dev/stdout "/var/log/apache2/other_vhosts_access.log" \
  && curl -sL https://deb.nodesource.com/setup_8.x | bash -\
  && apt install -y nodejs \
  && npm install npm@latest -g \
  && apt-get clean \
  && apt-get autoremove -y \
  && rm -fr /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/apt/archives/*.deb

RUN set -x \
  && /usr/local/bin/docker-php-ext-install zip pdo pdo_mysql opcache curl intl iconv bz2 xml xsl xmlrpc readline \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install gd

USER root
ADD deploy/docker/app.conf /etc/apache2/sites-enabled/000-app.conf
ADD deploy/docker/docker-entrypoint.sh /docker-entrypoint.sh

COPY . /app

RUN set -x \
  && /bin/chown -R www-data:www-data /app \
  && chmod +x /docker-entrypoint.sh

WORKDIR /app

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
