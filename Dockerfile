FROM alpine:latest

RUN \
  echo "http://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories \
  && echo "http://dl-cdn.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories \
  && echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
  && apk --no-cache  update \
  && apk --no-cache  upgrade \
  && apk --no-cache add build-base git openssh openjdk8 \
      php7 \
      php7-ctype \
      php7-curl \
      php7-dev \
      php7-dom \
      php7-fileinfo \
      php7-ftp \
      php7-iconv \
      php7-json \
      php7-mbstring \
      php7-mysqlnd \
      php7-openssl \
      php7-pdo \
      php7-pdo_sqlite \
      php7-pear \
      php7-phar \
      php7-posix \
      php7-session \
      php7-simplexml \
      php7-sqlite3 \
      php7-tokenizer \
      php7-xml \
      php7-xmlreader \
      php7-xmlwriter \
      php7-zip \
      php7-zlib \
  && rm -rf /var/cache/apk/* /tmp/*

RUN pecl install xdebug \
  && echo "zend_extension=/usr/lib/php7/modules/xdebug.so" >> /etc/php7/conf.d/xdebug.ini 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
