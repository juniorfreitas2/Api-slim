<?php

$container = $app->getContainer();

/**
 * Converte os Exceptions entro da Aplicação em respostas JSON
 */
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        return $c['response']->withStatus($statusCode)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};

//view renderer
$container['renderer'] = function($c) {
	$settings = $c->get('settings')['renderer'];

	return new Slim\Views\PhpRenderer($settings['template_path']);
};