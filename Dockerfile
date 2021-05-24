FROM php:7.2-fpm


RUN apt-get update
#RUN apt-get install -y mysql-client
RUN docker-php-ext-install pdo_mysql

# apt install
RUN apt-get update && \
    apt-get -y install \
        gnupg2 && \
    apt-key update && \
    apt-get update && \
    apt-get -y install \
            wget \
            zip \
            git \
            g++ \
            curl \
            imagemagick \
            libfreetype6-dev \
            libcurl3-dev \
            libicu-dev \
            libjpeg-dev \
            libjpeg62-turbo-dev \
            libmagickwand-dev \
            libpq-dev \
            libpng-dev \
            libxml2-dev \
            zlib1g-dev \
            mariadb-client \
            postgresql-server-dev-all \
            openssh-client \
            nano \
            unzip \
        --no-install-recommends && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# docker php install
RUN docker-php-ext-install \
                        zip \
                        intl \
                        curl \
                        mbstring \
                        pdo_mysql \
                        exif \
                        pdo_pgsql \
                        pdo \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd


