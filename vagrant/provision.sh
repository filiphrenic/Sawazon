#!/bin/sh

# PHP 5.6
sudo export LC_ALL=en_US.UTF-8
sudo export LANG=en_US.UTF-8
sudo add-apt-repository -y ppa:ondrej/php5-5.6
sudo apt-get update
sudo apt-get -y install php5 php5-mysql php5-gd

# MySQL and Apache
export DEBIAN_FRONTEND="noninteractive"
echo "mysql-server mysql-server/root_password password root" | sudo debconf-set-selections
echo "mysql-server mysql-server/root_password_again password root" | sudo debconf-set-selections
sudo apt-get install -y mysql-server-5.6
sudo service mysql restart


#composer
sudo su
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

cat << EOF >> /etc/apache2/apache2.conf
<Directory "/var/www/html">
    AllowOverride All
</Directory>
EOF

a2enmod rewrite
service apache2 restart
cd /var/www/html && composer install
