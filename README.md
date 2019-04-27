[<img src="https://avatars0.githubusercontent.com/u/993323"  height="100px">](https://github.com/yiisoft)

#### Yii 2 Restful Api
居于yii2开发的restful风格api

#### 如何安装
首先执行`php composer.phar install`命令对项目进行安装操作

#### 运行环境
Php 7.1.9  
Yii 2.0.14  
Nginx 1.13.7  
Redis 4.0.8  
Mysql 5.6.16

#### 环境安装（Docker）  
[web环境docker一键安装](https://github.com/little-bit-shy/docker-web)

#### Nginx路由优化配置
```bash
server {
    listen 888; 
    server_name localhost;
    
    # cors跨域处理
    location / {
             if ($request_method = OPTIONS) {
                add_header Access-Control-Allow-Origin *;
                add_header Access-Control-Allow-Credentials true;
                add_header Access-Control-Allow-Methods 'GET,POST,OPTIONS';
                add_header 'Access-Control-Allow-Headers' 'DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,X-Custom-Header';
                return 204;
            }
    }

    # 直接输入域名进入的目录和默认解析的文件
    location / {
        index index.php;
        try_files $uri $uri/ /index.php?r=$uri&$args;
        root /usr/local/nginx/www/vhost/www/myself/yii2-rest/web/;
    }
    
    # 解析.php的文件
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME /usr/local/nginx/www/vhost/www/myself/yii2-rest/web/$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
访问域名`http://127.0.0.1:888/v1/site/login`  
