<?php

declare(strict_types=1);

namespace src\Controller;

use src\Entity\Chat;
use src\Http\Response;
use src\Repository\ChatRepository;
use src\Router\Route;
use src\Router\Router;
use src\Templating\Render;

#[Route(path: '/message', name: 'message')]
class Message implements Controller
{
    public function __Construct(private Router $router)
    {
    }

    public function display(): void
    {
        $chatRepository = new ChatRepository();

        if (!empty($_POST['pseudo']) && !empty($_POST['message'])){
            $chat = new Chat();
            $chat->pseudo = $_POST['pseudo'];
            $chat->message = $_POST['message'];

            $chatRepository->insert($chat);
        }

        $results = $chatRepository->fetchAll();

        $messages = '';
        foreach ($results as $chat)
        {
            $messages .= (new Render())->render(
                'partials/message',
                [
                    'pseudo'=> $chat->pseudo,
                    'message'=> $chat->message,
                    'path'=> $this->router->getPath('deleteChat',['id'=> $chat->id])
                ]
            );
        }

        $content = (new Render()) ->render('layout',[
           'content' => (new Render())->render('chat', ['chat'=>$messages])
        ]);

        $response = new Response($content);
        $response->display();
    }
}