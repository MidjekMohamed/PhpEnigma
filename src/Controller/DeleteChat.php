<?php

declare(strict_types=1);

namespace src\Controller;

use src\Database\Connector;
use src\Http\Response;
use src\Router\Router;
use src\Router\Route;

#[Route(path: '/deleteChat', name: 'deleteChat')]
class DeleteChat implements Controller
{
    public function __construct(private Router $router)
    {
    }

    public function display(): void
    {
        $chatId = $_GET['id'] ?? null;
        if ($chatId !== null)
        {
            $pdo = Connector::getPDO();
            $statement = $pdo->prepare('DELETE FROM `chat` WHERE id = :id');
            $statement->bindParam('id', $chatId);
            $statement->execute();
        }
        $response = new Response('', 307, ['location: '.$this->router->getPath('message')]);
        $response->display();
    }
}