# Origin image
FROM ubuntu:latest

# Meta Information
MAINTAINER Wang Yihang "wangyihanger@gmail.com"

# update
RUN apt update

# Set timezone
RUN apt install -y tzdata
RUN echo "Asia/Shanghai" > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata

# Setup Server Environment
RUN apt install -y \
    apache2 \
    libapache2-mod-php \
    php \
    php-gd \
    php-mysql

RUN phpenmod gd && \
    a2enmod rewrite

# Entry point
ENTRYPOINT service apache2 restart && /bin/bash
