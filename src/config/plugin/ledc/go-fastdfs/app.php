<?php

return [
    'enable' => true,
    //自定义认证的路由
    'auth' => '/upload/auth',
    //添加允许跨域的请求头
    'allow_origin' => true,
    //谷歌二步验证器密钥
    'google2fa' => '{{GOOGLE2FA}}',
];
