# Origin image
FROM ubuntu:latest

# Meta Information
MAINTAINER Wang Yihang "wangyihanger@gmail.com"

# update
RUN apt update

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
ENTRYPOINT service apache2 start && /bin/bash