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

# .htaccess
cat << EOF >> /var/www/html/.htaccess
<IfModule mod_rewrite.c>
    Options +FollowSymLinks
    RewriteEngine On

    RewriteCond %{SCRIPT_FILENAME} !-d
    RewriteCond %{SCRIPT_FILENAME} !-f

    RewriteRule ^.*$ ./index.php
</IfModule>
EOF

a2enmod rewrite
service apache2 restart
cat << EOF >> /etc/apache2/sites-availible/000-default.conf
<Directory "/var/www/html">
    AllowOverride All
</Directory>

exit

sudo apt-get install -y debconf-utils
export DEBIAN_FRONTEND="noninteractive"

sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password root"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password root"

sudo apt-get install -y mysql-server-5.6

mysql_secure_installation
