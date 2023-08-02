<?php

namespace Ledc\GoFastdfs;

use Exception;
use Ledc\GoFastdfs\Library\GoogleAuthenticator;

/**
 * 安装
 */
class Install
{
    /**
     * 常量
     */
    const WEBMAN_PLUGIN = true;

    /**
     * @var array
     */
    protected static array $pathRelation = array(
        'config/plugin/ledc/go-fastdfs' => 'config/plugin/ledc/go-fastdfs',
    );

    /**
     * Install
     * @return void
     * @throws Exception
     */
    public static function install(): void
    {
        $config_app_path = __DIR__ . '/config/plugin/ledc/go-fastdfs/app.php';
        $config_app_content = file_get_contents($config_app_path);
        $google = new GoogleAuthenticator();
        $app_secret = $google->createSecret();
        $config_app_content = str_replace(['{{GOOGLE2FA}}'], [$app_secret], $config_app_content);
        file_put_contents($config_app_path, $config_app_content);
        static::installByRelation();
    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall(): void
    {
        self::uninstallByRelation();
    }

    /**
     * installByRelation
     * @return void
     */
    public static function installByRelation(): void
    {
        foreach (static::$pathRelation as $source => $dest) {
            if ($pos = strrpos($dest, '/')) {
                $parent_dir = base_path() . '/' . substr($dest, 0, $pos);
                if (!is_dir($parent_dir)) {
                    mkdir($parent_dir, 0777, true);
                }
            }
            //symlink(__DIR__ . "/$source", base_path()."/$dest");
            copy_dir(__DIR__ . "/$source", base_path() . "/$dest");
            echo "Create $dest
";
        }
    }

    /**
     * uninstallByRelation
     * @return void
     */
    public static function uninstallByRelation(): void
    {
        foreach (static::$pathRelation as $source => $dest) {
            $path = base_path() . "/$dest";
            if (!is_dir($path) && !is_file($path)) {
                continue;
            }
            echo "Remove $dest
";
            if (is_file($path) || is_link($path)) {
                unlink($path);
                continue;
            }
            remove_dir($path);
        }
    }
}