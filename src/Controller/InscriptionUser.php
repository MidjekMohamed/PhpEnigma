<?php

declare(strict_types=1);

namespace src\Controller;

use src\Entity\Utilisateur;
use src\Http\Response;
use src\Repository\ConnexionRepository;
use src\Router\Route;
use src\Router\Router;
use src\Templating\Render;

#[Route(path: '/inscription', name: 'inscription')]
class InscriptionUser implements Controller
{
    public function __Construct(private Router $router)
    {
    }

    public function display(): void
    {
        $connexionRepository = new ConnexionRepository();

        if(!empty($_POST['pseudo']) && !empty($_POST['mdpasse'])) {
            $utilisateur = new Utilisateur();
            $utilisateur->pseudo = $_POST['pseudo'];
            $utilisateur->mdpasse = $_POST['mdpasse'];

            $connexionRepository->insert($utilisateur);
        }

        $results = $connexionRepository->fetchAll();

        $utilisateurs = '';
        foreach ($results as $utilisateur)
        {
            $option = [
                'cost'=>12,
            ];
            $passwordHash = password_hash($utilisateur->mdpasse, PASSWORD_BCRYPT, $option);

            $utilisateurs .= (new Render())->render(
                'partials/utilisateur',
                [
                    'pseudo'=> $utilisateur->pseudo,
                    'mdpasse'=> $passwordHash,
                ]
            );
        }

        $content = (new Render())->render('layout',[
            'content' => (new Render())->render('inscription', ['utilisateur'=>$utilisateurs])
        ]);

        $response = new Response($content);
        $response->display();
    }

}