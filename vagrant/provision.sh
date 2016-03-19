#!/bin/sh

sudo su
#install php 5.6

apt-get install -y language-pack-en-base
LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php5-5.6 -y
apt-get update -y
apt-get install php5 php5-mysql php5-xdebug php5-gd -y
apt-get update -y

#xdebug

cat << EOF >> /etc/php5/apache2/conf.d/20-xdebug.ini
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_host=10.0.2.2
xdebug.remote_port=9000
xdebug.idekey=vagrant
EOF

cat << EOF >> /etc/php5/apache2/php.ini
[Xdebug]
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_host=10.0.2.2
xdebug.remote_port=9000
xdebug.idekey=vagrant
EOF

php5enmod xdebug

#composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

service apache2 restart

exit

# sudo apt-get install mysql-server-5.6
