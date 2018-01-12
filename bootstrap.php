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

$app = new \Slim\App($settings);

require __DIR__.'/src/dependencies.php';

require __DIR__.'/src/routes.php';


$app->run();