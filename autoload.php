<?php

function autoload($className) {
    $classPath = "src\\$className.php";
    if (file_exists($classPath)) {
        require_once $classPath;
    }
    // $toolsPath = lcfirst($className).".php";
    // if (file_exists($toolsPath)) {
    //     require_once $toolsPath;
    // }
}
spl_autoload_register("autoload");
