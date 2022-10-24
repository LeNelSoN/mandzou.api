<?php

use Controllers\DatabaseController;
use Helpers\HttpRequest;
use Helpers\HttpResponse;
use Services\DatabaseService;

    $_ENV["current"] = "dev"; 
    $config = file_get_contents("src/configs/".$_ENV["current"].".config.json");
    $_ENV['config'] = json_decode($config);

    if($_ENV["current"] == "dev"){
        $origin = "http://localhost:3000";
    }
    else if($_ENV["current"] == "prod"){
        $origin = "http://nomdedomaine.com";
    }

    header("Access-Control-Allow-Origin: $origin");

    require_once 'autoload.php';
    Autoload::register();

    $request = HttpRequest::instance();
    $tables = DatabaseService::getTables();
    if(isset($tables)){
        $controller = new DatabaseController($request);
    }
    