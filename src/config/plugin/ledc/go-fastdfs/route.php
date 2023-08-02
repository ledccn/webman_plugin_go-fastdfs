<?php

use Ledc\GoFastdfs\Auth;
use support\Request;
use Webman\Route;

/**
 * 路由配置
 * - 注意事项：未关闭默认路由时，敏感接口的控制器，禁止放到app目录；
 * - 如果必须放到app目录下，请使用全局中间件、应用中间件或其他方法做权限验证；
 *
 * @link https://www.workerman.net/doc/webman/route.html
 */
Route::any(config('plugin.ledc.go-fastdfs.app.auth'), function (Request $request) {
    // 如果是OPTIONS请求则返回一个空响应
    if (strtoupper($request->method()) === 'OPTIONS') {
        $response = response('');
        if (config('plugin.ledc.go-fastdfs.app.allow_origin', true)) {
            // 给响应添加跨域相关的http头
            $response->withHeaders([
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Origin' => $request->header('Origin', '*'),
                'Access-Control-Allow-Methods' => '*',
                'Access-Control-Allow-Headers' => '*',
            ]);
        }
        return $response;
    }

    //用户自定义认证
    try {
        $rs = Auth::canAccess($request);
        return response($rs ? 'ok' : 'fail');
    } catch (Exception|Error|Throwable $throwable) {
        return response('failed:' . $throwable->getMessage());
    }
});
