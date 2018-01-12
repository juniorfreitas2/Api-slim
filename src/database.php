<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

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

return $entityManager;