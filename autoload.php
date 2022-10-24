<?php 
class Autoload{

    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoloader'));
    }

    static function autoloader($class){
        require 'src/'.$class.'.php';
    }
}