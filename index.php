<?php

    $_ENV["current"] = "dev"; 
    $config = file_get_contents("configs/".$_ENV["current"].".config.json");
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
    // Récupération de la requete

    $request = filter_var(trim($_SERVER["REQUEST_URI"], '/'), FILTER_SANITIZE_URL);

    //la ligne suivante est à commenter si vous utilisez le virtualhost
    $request = str_replace('mandzou.api/','', $request);

    $controller = new DatabaseController($request);

    $response = $_SERVER["REQUEST_METHOD"].'/'.$request;

    echo $response;