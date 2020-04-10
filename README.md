#### 定时任务管理系统（crontab）
```bash
yii2-rest           项目目录
├─admin              前端页面（基于iview）
│  ├─build           前端配置文件
│  ├─src             前端具体业务
│  └─
├─commands           Cli脚本目录
├─components         扩展组件目录
├─config             公共配置目录
├─controllers        控制器目录
├─models             模型目录
├─modules            模块目录
│  ├─v1              v1模块目录
│  │  ├─config       配置目录
│  │  ├─controllers  控制器目录
│  │  ├─models	     模型目录
│  │  │  ├─form	     表单模型目录
│  │  │  ├─redis     Redis模型目录
│  │  │  └─ ...      对应业务相关MySQL模型目录
│  │  ├─rules	     权限规则目录
│  │  └─Module.php   初始化模块脚本
│  └─
├─web                项目入口目录
│ ├─dev.php	         开发入口脚本
│ ├─prod.php	     生产入口脚本
│ └─test.php	     测试入口脚本
│
├─composer.json     composer 定义文件
├─composer.phar     composer 工具
├─README.md         README 文件
├─yii_dev	        开发Cli入口脚本
├─yii_prod	        生产Cli入口脚本
├─yii_test	        测试Cli入口脚本
└─yii2restful.sql   项目初始化数据Sql文件
```

#### 如何安装
操作界面脚本在admin目录下，安装依赖（`npm install`）

修改配置文件接口链接`/admin/build/config.js`，ajaxUrl（后端链接）url（前端链接）

编译脚本（`npm run build`）

服务端项目，安装依赖(`php composer.phar install`)

修改后端配置文件`/config/db.php`、`/config/redis.php`、`/config/mailer.php`、`/config/task.php`

#### 运行环境
Php 7.2.7  
Yii 2.0.14  
Nginx 1.13.7  
Redis 4.0.8  
Mysql 5.6.16

#### 环境安装（Docker）  
[web环境docker一键安装](https://github.com/little-bit-shy/docker-web)

#### Nginx路由优化配置
```bash
server {
    listen 80;
    server_name localhost;
    autoindex off;

    #直接输入域名进入的目录和默认解析的文件
    location / {
        // 根据你的环境使用不同的脚本入口 prod.php、test.php、dev.php
        try_files $uri $uri/ /prod.php?s=$uri&$args;
    }

    #解析.php的文件
    location ~ \.php$ {
        root /www/yii2-rest/web/;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
接口系统访问域名`http://localhost/v1/site/login`

#### 定时任务管理系统启动命令
根据你的环境使用不同的脚本入口 yii_prod、yii_test、yii_dev

任务分发服务启动`php yii_test server/index`

任务代理服务启动`php yii_test client/index`

代理服务可开启多个，看个人需求

`注意：`
分发服务和代理服务通讯的证书在`/commands/task/ca`下面，这里建议替换自己的证书

生成证书方法在`/help/buildCa`下面

```bash
[root@localhost buildCa]# ll
total 5
-rwxrwxrwx. 1 root root  700 Apr 10 11:38 build.sh
-rwxrwxrwx. 1 root root  333 Apr 10 10:52 new_ca.sh
-rwxrwxrwx. 1 root root  635 Apr 10 11:33 new_client.sh
-rwxrwxrwx. 1 root root  263 Apr 10 10:54 new_server.sh
-rwxrwxrwx. 1 root root 1155 Mar  5 10:36 openssl.conf
[root@localhost buildCa]# bash build.sh
Usage: build.sh (start|clear)
        start 构建证书
        clear 清除构建证书产生的资源（所有）文件

```

构建证书示例

```bash
[root@localhost buildCa]# bash build.sh start
开始构建Ca
Generating RSA private key, 2048 bit long modulus
....................................+++
..................................+++
e is 65537 (0x10001)
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [XX]:aa
State or Province Name (full name) []:aa
Locality Name (eg, city) [Default City]:aa
Organization Name (eg, company) [Default Company Ltd]:aa
Organizational Unit Name (eg, section) []:aa
Common Name (eg, your name or your server's hostname) []:
Email Address []:

Please enter the following 'extra' attributes
to be sent with your certificate request
A challenge password []:
An optional company name []:
Signature ok
subject=/C=aa/ST=aa/L=aa/O=aa/OU=aa
Getting Private key
Using configuration from ./openssl.conf
开始构建Server
Generating RSA private key, 2048 bit long modulus
................................+++
........................................................................+++
e is 65537 (0x10001)
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [XX]:aa
State or Province Name (full name) []:aa
Locality Name (eg, city) [Default City]:aa
Organization Name (eg, company) [Default Company Ltd]:aa
Organizational Unit Name (eg, section) []:aa
Common Name (eg, your name or your server's hostname) []:
Email Address []:

Please enter the following 'extra' attributes
to be sent with your certificate request
A challenge password []:
An optional company name []:
Using configuration from ./openssl.conf
Check that the request matches the signature
Signature ok
The Subject's Distinguished Name is as follows
countryName           :PRINTABLE:'aa'
stateOrProvinceName   :ASN.1 12:'aa'
localityName          :ASN.1 12:'aa'
organizationName      :ASN.1 12:'aa'
organizationalUnitName:ASN.1 12:'aa'
Certificate is to be certified until Apr 10 03:52:40 2021 GMT (365 days)
Sign the certificate? [y/n]:y


1 out of 1 certificate requests certified, commit? [y/n]y
Write out database with 1 new entries
Data Base Updated
开始构建Client
Generating RSA private key, 1024 bit long modulus
.................................................++++++
.................++++++
e is 65537 (0x10001)
Enter pass phrase for .//users/client.key:
Verifying - Enter pass phrase for .//users/client.key:
Enter pass phrase for .//users/client.key:
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [XX]:aa
State or Province Name (full name) []:aa
Locality Name (eg, city) [Default City]:aa
Organization Name (eg, company) [Default Company Ltd]:aa
Organizational Unit Name (eg, section) []:aa
Common Name (eg, your name or your server's hostname) []:
Email Address []:

Please enter the following 'extra' attributes
to be sent with your certificate request
A challenge password []:
An optional company name []:
Using configuration from ./openssl.conf
Check that the request matches the signature
Signature ok
The Subject's Distinguished Name is as follows
countryName           :PRINTABLE:'aa'
stateOrProvinceName   :ASN.1 12:'aa'
localityName          :ASN.1 12:'aa'
organizationName      :ASN.1 12:'aa'
organizationalUnitName:ASN.1 12:'aa'
Certificate is to be certified until Apr 10 03:53:05 2021 GMT (365 days)
Sign the certificate? [y/n]:y


1 out of 1 certificate requests certified, commit? [y/n]y
Write out database with 1 new entries
Data Base Updated
Enter pass phrase for .//users/client.key:
Enter Export Password:
Verifying - Enter Export Password:
Enter Import Password:
MAC verified OK
Enter Import Password:
MAC verified OK
Enter PEM pass phrase:
Verifying - Enter PEM pass phrase:
[root@localhost buildCa]# ll
total 8
-rwxrwxrwx. 1 root root  700 Apr 10 11:38 build.sh
-rwxrwxrwx. 1 root root  116 Apr 10 11:53 index.txt
-rwxrwxrwx. 1 root root   20 Apr 10 11:53 index.txt.attr
-rwxrwxrwx. 1 root root   20 Apr 10 11:52 index.txt.attr.old
-rwxrwxrwx. 1 root root   58 Apr 10 11:52 index.txt.old
-rwxrwxrwx. 1 root root  333 Apr 10 10:52 new_ca.sh
drwxrwxrwx. 1 root root    0 Apr 10 11:53 newcerts
-rwxrwxrwx. 1 root root  635 Apr 10 11:33 new_client.sh
-rwxrwxrwx. 1 root root  263 Apr 10 10:54 new_server.sh
-rwxrwxrwx. 1 root root 1155 Mar  5 10:36 openssl.conf
drwxrwxrwx. 1 root root    0 Apr 10 11:52 private
-rwxrwxrwx. 1 root root    5 Apr 10 11:53 serial
-rwxrwxrwx. 1 root root    5 Apr 10 11:52 serial.old
drwxrwxrwx. 1 root root    0 Apr 10 11:52 server
drwxrwxrwx. 1 root root    0 Apr 10 11:53 users
```
系统带有预警邮件通知功能

使用预警功能前只需修改指定配置文件即可

![img](/help/image/8.jpg)

只需在后台指定接收通知的用户即可

![img](/help/image/7.jpg)

邮件效果展示

![img](/help/image/6.jpg)


#### 效果展示
初始化账号密码 root/123456

![img](/help/image/1.jpg)

![img](/help/image/2.jpg)

![img](/help/image/3.jpg)

![img](/help/image/4.jpg)

![img](/help/image/5.jpg)

![img](/help/image/9.png)

![img](/help/image/10.jpg)




