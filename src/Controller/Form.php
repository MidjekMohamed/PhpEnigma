<?php

declare(strict_types=1);

namespace src\Controller;

use src\Entity\Mood;
use src\Repository\MoodRepository;
use src\Router\Router;
use src\Router\Route;
use src\Http\Response;
use src\Templating\Render;

#[Route(path: '/form', name: 'form')]
class Form implements Controller
{
    public function __Construct(private Router $router){
    }

    public function display(): void
    {
        $moodRepository = new MoodRepository();

        if (!empty($_POST['mood'])){
            $mood = new Mood();
            $mood->mood = $_POST['mood'];

            $moodRepository->insert($mood);
        }

        $results = $moodRepository->fetchAll();

        $moods = '';
        foreach ($results as $mood)
        {
            $moods .= (new Render())->render(
                'partials/mood',
                [
                    'mood'=> $mood->mood,
                    'path'=> $this->router->getPath('deleteMood', ['id'=> $mood->id])
                ]
            );
        }

        $content = (new Render()) ->render('layout',[
            'content' => (new Render())->render('form', ['moods'=>$moods])
        ]);

        $response = new Response($content);
        $response->display();
    }
}