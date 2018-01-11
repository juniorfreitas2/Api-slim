<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$container = new \Slim\Container();
$isDevMode = true;

/**
 * Diretório de Entidades e Metadata do Doctrine
 */
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Models/Entity"), $isDevMode);

/**
 * Array de configurações da nossa conexão com o banco
 */

$conn = array(
    'password' => '123',
	'dbname'   => 'slim',
    'user' 	   => 'root',
    'host'     => 'localhost',
    'driver'   => 'pdo_mysql'
);

/**
 * Instância do Entity Manager
 */
$entityManager = EntityManager::create($conn, $config);

/**
 * Coloca o Entity manager dentro do container com o nome de em (Entity Manager)
 */
$container['em'] = $entityManager;

return $container;