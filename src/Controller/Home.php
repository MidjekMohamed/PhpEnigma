<?php

declare(strict_types=1);

namespace src\Controller;

use src\Http\Response;
use src\Router\Router;
use src\Router\Route;
use src\Templating\Render;

#[Route(path: '/home', name: 'accueil')]
class Home implements Controller
{

    public function __construct(private Router $router)
    {
    }

    public function display(): void{
        $content = (new Render()) ->render('layout',[
            'content' => (new Render())->render('home')
        ]);

        $response = new Response($content, 404);
        $response->display();
    }
}

?>