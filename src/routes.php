<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Entity\User;
use Firebase\JWT\JWT;

$app->group('/v1', function() {
    $this->group('/user', function() {
        $this->get('', '\App\Controllers\UserController:listUser');
        $this->post('', '\App\Controllers\UserController:createUser');
        
        /**
         * Validando se tem um integer no final da URL
         */
        $this->get('/{id:[0-9]+}', '\App\Controllers\UserController:viewUser');
        $this->put('/{id:[0-9]+}', '\App\Controllers\UserController:updateUser');
        $this->delete('/{id:[0-9]+}', '\App\Controllers\UserController:deleteUser');
    });

    $this->group('/auth', function() {
        $this->get('', \App\Controllers\AuthController::class);
    });

});