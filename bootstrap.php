<?php

require __DIR__.'/vendor/autoload.php';

//$settings = require __DIR__.'/src/settings.php';
$configs = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configs);

/**
 * Coloca o Entity manager dentro do container com o nome de em (Entity Manager)
 */
$settings['em'] = require __DIR__.'/src/database.php';
$settings['secretkey'] = "secretlok";

$app = new \Slim\App($settings);

require __DIR__.'/src/dependencies.php';

require __DIR__.'/src/routes.php';

// $app->add(new \Slim\Middleware\HttpBasicAuthentication([
//     "users" => [
//         "root" => "toor"
//     ],
//     // *
//     //  * Blacklist - Deixa todas liberadas e só protege as dentro do array
     
//     "path" => ["/auth"],
//     /**
//      * Whitelist - Protege todas as rotas e só libera as de dentro do array
//      */
//     // "passthrough" => ["/auth"],
// ]));

$app->add(new \Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/", //Regex para encontrar o Token nos Headers - Livre
    "header" => "X-Token", //O Header que vai conter o token
    "path" => "/", //Vamos cobrir toda a API a partir do /
    "passthrough" => ["/auth"], //Vamos adicionar a exceção de cobertura a rota /auth
    "realm" => "Protected", 
    "secret" => $settings['secretkey'] //Nosso secretkey criado 
]));

$app->run();