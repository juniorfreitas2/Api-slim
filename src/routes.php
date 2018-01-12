<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Entity\User;

//rota opcional
$app->get('/edit[/{id}]', function($request, $response) {
	$id = $request->getAttribute('id') ?? 'id opcional';

	//$response->getBody()->write("response writing");

	return $id;
});


// User
$app->get('/user', function (Request $request, Response $response) use ($app) {
    
    $entityManager = $this->get('em');

    $booksRepository = $entityManager->getRepository('App\Models\Entity\User');
    
    $books = $booksRepository->findAll();
    
    $return = $response->withJson($books, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->get('/user/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');

    $id = $route->getArgument('id');
    
    $entityManager = $this->get('em');
    
    $booksRepository = $entityManager->getRepository('App\Models\Entity\User');
    
    $book = $booksRepository->find($id);        
    
    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
    
});


$app->post('/user', function (Request $request, Response $response) use ($app) {
   
   $params = (object) $request->getParams();
    /**
     * Pega o Entity Manager do nosso Container
     */
    $entityManager = $this->get('em');
    /**
     * Instância da nossa Entidade preenchida com nossos parametros do post
     */
    $book = (new User())->setName($params->name)
        ->setPassword($params->password);
    
    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);
    $entityManager->flush();
    $return = $response->withJson($book, 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->put('/user/{id}', function (Request $request, Response $response) use ($app) {
   /**
     * Pega o ID do livro informado na URL
     */
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    /**
     * Encontra o Livro no Banco
     */ 
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\User');
    $book = $booksRepository->find($id);   
    /**
     * Atualiza e Persiste o Livro com os parâmetros recebidos no request
     */
    $book->setName($request->getParam('name'))
        ->setPassword($request->getParam('password'));
    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);
    $entityManager->flush();        
    
    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;

});


$app->delete('/user/{id}', function (Request $request, Response $response) use ($app) {
    /**
     * Pega o ID do livro informado na URL
     */
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    /**
     * Encontra o Livro no Banco
     */ 
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\User');
    $book = $booksRepository->find($id);   
    /**
     * Remove a entidade
     */
    $entityManager->remove($book);
    $entityManager->flush(); 
    $return = $response->withJson(['msg' => "Deletando o usuário {$id}"], 204)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
