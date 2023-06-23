# Banco del tiempo
Esta aplicación permite la comunicación entre usuarios, con el fin de compartir conoocimientos.


## Empezando
Las siguientes instrucciones le indicarán como poner en marcha la plataforma en un servidor Linux.

Además de las instrucciones, se proporciona un manual más detallado en /bdt/Manual de usuario.pdf

## Instalando
Desde la consola de Ubuntu empezamos a ejecutar las siguientes instrucciones:
```
sudo apt update
sudo apt install apache2
sudo ufw allow in "Apache"
sudo apt install mysql-server
```
```
mysql -u root -p
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin';
FLUSH PRIVILEGES;
exit;
```
```
sudo apt install pgp libapache2-mod-php php-mysql
sudo apt update
sudo apt install software-properties-common gnupg2 -y
sudo add-apt-repository ppa:ondrej/php
sudo update-alternatives --config php
sudo apt install php8.2-mysql
```
```
sudo mkdir/var/www/bdt
sudo chown -R $USER:$USER /var/www/bdt
    Y se copia el siguiente codigo:
        <VirtualHost *:80>
            ServerName bdt
            ServerAlias www.bdt
            ServerAdmin webmaster@localhost
            DocumentRoot /var/www/bdt
            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined
        </VirtualHost>
        
    Guardamos y salimos


sudo a2ensite bdt
sudo a2dissite 000-default
sudo systemctl reload apache2
sudo chmod 777 -R /var/www/bdt
sudo nano /etc/apache2/apache2.conf
    Y al final del fichero añadimos el siguiente codigo:
        <FilesMatch \.php$>
            SetHandler application/x-httpd-php
        </FilesMatch>
        
    Guardamos y salimos

sudo a2dismod mpm_event && sudo a2enmod mpm_prefork && sudo a2enmod php8.2
sudo service apache2 restart
```

### Requerimientos de instalación
MySql       #Gestor de bases de datos
PHP8.2      #Lenguaje utilizados

