#!/bin/bash
set -o pipefail

# Install global dependencies
# NOTE: Assumes Ubuntu 18.04 (PHP 7.4 not in repository until Ubuntu 20)
DEBIAN_FRONTEND=noninteractive
apt-get update
apt-get install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt-get update
apt-get install -y php7.4 php7.4-mbstring php7.4-xml php7.4-mysql apache2 libapache2-mod-php

# Remove apache's default html directory
rm -rf /var/www/html

# Enable Apache rewrite module
a2enmod rewrite

# Apache service gets auto-started after install. Stop the service until the appropriate hook launches it
service apache2 stop
