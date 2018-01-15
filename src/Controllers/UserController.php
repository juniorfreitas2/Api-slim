<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\User;

/**
 * Controller v1 de livros
 */
class UserController {

    /**
     * Container Class
     * @var [object]
     */
    private $container;

    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container) {
        $this->container = $container;
    }
    
    /**
     * Listagem de Usuários
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function listUser($request, $response, $args) {
        $entityManager = $this->container->get('em');
        
        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        
        $users = $userRepository->findAll();
        
        $return = $response->withJson($users, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;        
    }
    
    /**
     * Cria um livro
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function createUser($request, $response, $args) {
        $params = (object) $request->getParams();
        /**
         * Pega o Entity Manager do nosso Container
         */
        $entityManager = $this->container->get('em');
        /**
         * Instância da nossa Entidade preenchida com nossos parametros do post
         */
        $user = (new User())->setName($params->name)
            ->setPassword($params->password);
        
        /**
         * Persiste a entidade no banco de dados
         */
        $entityManager->persist($user);
        $entityManager->flush();
        $return = $response->withJson($user, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Exibe as informações de um usuário 
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function viewUser($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id); 

        /**
         * Verifica se existe um usuário com a ID informada
         */
        if (!$user) {
            throw new \Exception("User not Found", 404);
        }    

        $return = $response->withJson($user, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;   
    }

    /**
     * Atualiza um usuário
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function updateUser($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Encontra o Usuário no Banco
         */ 
        $entityManager = $this->container->get('em');
        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);   

        /**
         * Verifica se existe um usuario com a ID informada
         */
        if (!$user) {
            throw new \Exception("User not Found", 404);
        }  

        /**
         * Atualiza e Persiste o usuário com os parâmetros recebidos no request
         */
        $user->setName($request->getParam('name'))
            ->setPassword($request->getParam('password'));

        /**
         * Persiste a entidade no banco de dados
         */
        $entityManager->persist($user);
        $entityManager->flush();        
        
        $return = $response->withJson($user, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Deleta um usuário
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function deleteUser($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Encontra o usuário no Banco
         */ 
        $entityManager = $this->container->get('em');
        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);   

        /**
         * Verifica se existe um usuário com a ID informada
         */
        if (!$user) {
            throw new \Exception("user not Found", 404);
        }  

        /**
         * Remove a entidade
         */
        $entityManager->remove($user);
        $entityManager->flush(); 
        $return = $response->withJson(['msg' => "Deletando o usuário {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;    
    }
    
}