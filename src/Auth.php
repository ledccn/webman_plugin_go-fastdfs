<?php

namespace Ledc\GoFastdfs;

use InvalidArgumentException;
use Ledc\GoFastdfs\Library\GoogleAuthenticator;
use support\Container;
use Webman\Http\Request;

/**
 * 用户自定义认证
 * -如果你是海量文件，又需要有自己的一些验证逻辑，建议使用自定义认证。
 * @link https://sjqzhang.github.io/go-fastdfs/
 */
class Auth
{
    /**
     * 鉴权
     * @param Request $request
     * @return bool
     */
    public static function canAccess(Request $request): bool
    {
        $auto_token = $request->input('auth_token');
        if (ctype_digit((string)$auto_token)) {
            return self::google($auto_token);
        }
        //验证其他格式的token...
        return false;
    }

    /**
     * 谷歌验证器：验证码
     * @param string $code
     * @return bool
     */
    private static function google(string $code): bool
    {
        $secret = config('plugin.ledc.go-fastdfs.app.google2fa', '');
        if (empty($secret)) {
            throw new InvalidArgumentException('未配置google2fa');
        }
        //纯数字：谷歌验证器
        $google = Container::get(GoogleAuthenticator::class);
        return $google->verifyCode($secret, $code, 2);
    }
}
