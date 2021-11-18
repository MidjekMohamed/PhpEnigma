<?php

declare(strict_types=1);

namespace src\Repository;

use src\Database\Connector;
use src\Entity\Utilisateur;

class ConnexionRepository{
    /**
     * @return array<Utilisateur>
     */
    public function fetchAll(): array{
        $pdo = Connector::getPDO();

        $statement = $pdo->query('SELECT * FROM `utilisateur`');
        $statement->execute();

        $statement->setFetchMode(\PDO::FETCH_CLASS, Utilisateur::class );
        return $statement->fetchAll();
    }

    public function insert(Utilisateur $utilisateur){
        $pdo = Connector::getPDO();

        $statement = $pdo->prepare('INSERT INTO `utilisateur` VALUES (null, :pseudo, :mdpasse)');
        $statement->bindParam('pseudo', $utilisateur->pseudo);
        $statement->bindParam('mdpasse', $utilisateur->mdpasse);
        $statement->execute();
    }
}