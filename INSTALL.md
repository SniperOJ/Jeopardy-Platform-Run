1. Update your system
```
sudo apt update && \
sudo apt upgrade -y && \
sudo apt dist-upgrade -y
```

2. Install git 
```
sudo apt install git -y
```

3. Clone this repo
```
sudo git clone https://github.com/WangYihang/SniperOJ.git /var/www/
```

4. Install dependencies
```
sudo apt install apache2
sudo apt install php7.0
sudo apt install php7.0-gd
sudo apt install php7.0-mysqli
sudo apt install libapache2-mod-php7.0
sudo apt install mysql-server
```

5. Configurations of php
```
phpenmod gd
a2enmod rewrite
```

6. Configurations of apache2
```
<Directory /var/www/>
        SetEnv CI_ENV production
        Options FollowSymLinks
        AllowOverride ALL
        Require all granted
</Directory>
```

7. Create folder to store captcha
```
mkdir /var/www/html/assets/captcha
chmod o+w /var/www/html/assets/captcha
```

8. Create database in MySQL
```
create database SniperOJ;
```

9. Import database
```
mysql -u root -p -D SniperOJ < database.sql
```

10. Config database.php
```
cd /var/www/application/config/
cp database.php.example database.php
修改 : 
username
password
database
```

11. Config SMTP service
```
1. cp email.php.example email.php

2. change these variables
$smtp_host
$smtp_port
$smtp_user
$smtp_pass

3.vi /var/www/application/controllers/User.php
search this string 'admin@sniperoj.cn'
replace it to your email addres
```

12. Restart MySQL and Apache
```
service mysql restart
service apache2 restart
```
