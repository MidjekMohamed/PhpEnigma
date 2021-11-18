<?php

declare(strict_types=1);


spl_autoload_register(function (string $className){
    $path = str_replace('\\',DIRECTORY_SEPARATOR,$className).'.php';
    require_once (__DIR__."/../$path");
});

use src\Router\Router;
use src\Exception\NotFoundHttpException;
use src\Http\Response;

$router = new Router();

try {
    $controllerName= $router->getController($_SERVER['PATH_INFO']?? '/home');
    $controller = new $controllerName($router);
    $controller->display();

    if(!$controller instanceof \src\Controller\Controller){
        throw new LogicException(
            sprintf('Controller "%s" must implement %s interface', $controllerName, Controller::class)
        );
    }

}catch (NotFoundHttpException $exception){
    $routerHome = $router->getPath('accueil');
    $routerInfo = $router->getPath('info');
    $routerQuery = $router->getPath('query', ['name'=>'Mohamed']);

    $content =<<<HTML
<html>
    <head>
        <title>Mon super site</title>
    </head>
    
    <body>
        <h1>404 Not Found</h1>
        <p>
            <a href="$routerHome">home</a>
            <a href="$routerInfo">info</a>
        </p>
    </body>
    
</html>
HTML;

    $response = new Response($content,404);
    $response->display();

}catch (Exception $exception){
    $response = new Response($exception->getMessage(), 500);
    $response->display();}


?>