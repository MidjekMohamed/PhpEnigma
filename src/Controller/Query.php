<?php

namespace src\Controller;

use src\Http\Response;
use src\Router\Router;
use src\Router\Route;
use src\Templating\Render;
#[Route(path: '/query', name: 'query')]
class Query implements Controller
{
    public function __construct(private Router $router)
    {
    }

    public function display(): void
    {
        $name = $_GET['name'] ?? 'anonyme';
        $content = $content = (new Render()) ->render('layout',[
            'content' => (new Render())->render('query',['name'=> $name]),
        ]);

        $response = new Response($content, 404);
        $response->display();
    }
}