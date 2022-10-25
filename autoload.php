<?php
class Autoload
{

    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoloader'));
    }

    static function autoloader($class)
    {
        $filePath='src/' . $class . '.php';
        if (file_exists($filePath)) {
            require $filePath;
        }

        $toolsPath = lcfirst($class) . ".php";
        if (file_exists($toolsPath)) {
            require_once $toolsPath;
        }
    }
}
