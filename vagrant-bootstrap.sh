#!/usr/bin/env bash

# Setup environment
locale-gen en_US.UTF-8

# Setup middleware
echo "Setting up middleware"
apt-get update
apt-get install -y apache2
apt-get install -y php5
apt-get install -y libapache2-mod-php5
apt-get install -y php5-cli
apt-get install -y php5-curl
apt-get install -y php5-gd
apt-get install -y php5-imagick
apt-get install -y qrencode
apt-get install -y phpunit

# Install Composer
echo "installing Composer"
php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer

# Setup virtual host
echo "Writing virtual host config"
echo "<VirtualHost *:80>
        ServerName test.dev
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/php-oath-server-suite/
        <Directory /var/www/php-oath-server-suite>
                Options FollowSymLinks MultiViews
                AllowOverride FileInfo
                Order allow,deny
                allow from all
        </Directory>
        ErrorLog /var/log/apache2/error.log
        CustomLog /var/log/apache2/access.log combined
</VirtualHost>" > /etc/apache2/sites-available/php-oath-server-suite.conf

echo "Setting hostname"
echo "ServerName \"php-oath-server-suite\"
" >> /etc/apache2/apache2.conf

echo "Enabling virtual host"
a2dissite 000-default.conf
a2ensite php-oath-server-suite.conf

# Restart apache
echo "Restarting Apache2"
service apache2 restart
