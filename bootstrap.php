<?php

require __DIR__.'/vendor/autoload.php';

$configs = require __DIR__.'/src/settings.php';

$container = new \Slim\Container($configs);

/**
 * Coloca o Entity manager dentro do container com o nome de em (Entity Manager)
 */
$settings['em'] = require __DIR__.'/src/database.php';
$settings['secretkey'] = "secretlok";

$app = new \Slim\App($settings);

require __DIR__.'/src/dependencies.php';

require __DIR__.'/src/routes.php';

$app->add(new \Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/", //Regex para encontrar o Token nos Headers - Livre
    "header" => "X-Token", //O Header que vai conter o token
    "path" => "/", //Vamos cobrir toda a API a partir do /
    "passthrough" => ["/v1/auth"], //Vamos adicionar a exceção de cobertura a rota /auth
    "realm" => "Protected", 
    "secret" => $settings['secretkey'] //Nosso secretkey criado 
]));

$app->run();