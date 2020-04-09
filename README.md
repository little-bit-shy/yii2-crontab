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
修改配置文件接口链接、编译脚本（`npm run build`）

执行`php composer.phar install`命令对项目进行依赖安装操作

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
        if ( $request_method = 'OPTIONS' ) {
            add_header Access-Control-Allow-Origin *;
            add_header Access-Control-Allow-Credentials true;
            add_header Access-Control-Allow-Methods 'GET,POST,OPTIONS';
            add_header 'Access-Control-Allow-Headers' 'x-access-token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,X-Custom-Header';
            add_header Access-Control-Max-Age 6000;
            return 204;
        }
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

![img](/help/image/9.jpg)

![img](/help/image/10.jpg)




