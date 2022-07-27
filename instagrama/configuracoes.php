<?php 

date_default_timezone_set("America/Sao_Paulo");

spl_autoload_register(function ($class_name){

    $model = __DIR__ . "/model/";
    $dao = __DIR__ . "/dao/";

    $pastas = [$model, $dao];
    foreach ($pastas as $pasta) {
        $arquivo = $pasta . $class_name . ".php";
        if(file_exists($arquivo)) {
            require_once $arquivo;
        }
    }

});

