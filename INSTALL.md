一. 更新源
```
sudo apt update && \
sudo apt upgrade -y && \
sudo apt dist-upgrade -y
```

二. 安装 git 
```
sudo apt install git -y
```

三. 克隆仓库
```
sudo git clone https://github.com/WangYihang/SniperOJ.git /var/www/
```

四. 安装依赖软件包
```
sudo apt install apache2
sudo apt install php7.0
sudo apt install php7.0-gd
sudo apt install php7.0-mysqli
sudo apt install libapache2-mod-php7.0
sudo apt install mysql-server
```

五. 配置 php 与 apache2
```
启用 gd 库用于生成二维码
phpenmod gd
启动 rewrite 模块用于美化 URL
a2enmod rewrite
```

六. 修改 apache2 配置文件
```
<Directory /var/www/>
        SetEnv CI_ENV production
        Options FollowSymLinks
        AllowOverride ALL
        Require all granted
</Directory>
```

七. 创建可写目录用于保存验证码
```
mkdir /var/www/html/assets/captcha
chmod o+w /var/www/html/assets/captcha
```

八. 创建数据库
```
create database SniperOJ;
```

九. 导入数据库
```
mysql -u root -p -D SniperOJ < database.sql
```

十. 配置数据库
```
cd /var/www/application/config/
cp database.php.example database.php
修改 : 
username
password
database
```

十一. 配置发信邮箱
```
1.cp email.php.example email.php

2.根据你的邮件服务提供商的配置说明进行配置
主要需要修改 : 
smtp_host
smtp_port
smtp_user
smtp_pass

3.然后vi /var/www/application/controllers/User.php
搜索到admin@sniperoj.cn
将其替换为自己邮箱
```

十二. 重启服务
```
service mysql restart
service apache2 restart
```
