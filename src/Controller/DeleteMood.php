<?php

declare(strict_types=1);

namespace src\Controller;

use src\Database\Connector;
use src\Http\Response;
use src\Router\Route;
use src\Router\Router;

#[Route(path: '/deleteMood', name: 'deleteMood')]
class DeleteMood implements Controller
{
    public function __construct(private Router $router)
    {
    }

    public function display(): void
    {
        $moodId = $_GET['id'] ?? null;
        if ($moodId !== null)
        {
            $pdo = Connector::getPDO();
            $statement = $pdo->prepare('DELETE FROM `mood` WHERE id = :id');
            $statement->bindParam('id', $moodId);
            $statement->execute();
        }
        $response = new Response('', 307, ['location: '.$this->router->getPath('form')]);
        $response->display();
    }
}