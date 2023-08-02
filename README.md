# Webman plugin ledc/go-fastdfs

## 安装

```
composer require ledc/go-fastdfs
```



## 简介

基于webman编写的用户自定义验证接口，适用于go-fastdfs分布式文件系统`auth_token`验证。



## 配置

- 项目目录下：`/config/plugin/ledc/go-fastdfs/app.php`


- Nginx配置

```php
location /upload/auth {
  proxy_set_header X-Real-IP $remote_addr;
  proxy_set_header Host $host;
  proxy_set_header X-Forwarded-Proto $scheme;
  proxy_http_version 1.1;
  proxy_set_header Connection "";
  proxy_pass http://127.0.0.1:8787;
}
```



## go-fastdfs

基于http协议的分布式文件系统，它基于大道至简的设计理念，一切从简设计，使得它的运维及扩展变得更加简单，它具有高性能、高可靠、无中心、免维护等优点。

- 源码：https://github.com/sjqzhang/go-fastdfs
- 文档：https://sjqzhang.github.io/go-fastdfs/