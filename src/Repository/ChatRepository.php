<?php

namespace src\Repository;

use src\Database\Connector;
use src\Entity\Chat;
use src\Entity\Mood;

class ChatRepository
{
    /**
     * @return array<Mood>
     */

    public function fetchAll(): array{
        $pdo = Connector::getPDO();

        $statement = $pdo->query('SELECT * FROM `chat`');
        $statement->execute();

        $statement->setFetchMode(\PDO::FETCH_CLASS, Chat::class );
        return $statement->fetchAll();
    }

    public function insert(Chat $chat){
        $pdo = Connector::getPDO();

        $statement = $pdo->prepare('INSERT INTO `chat` VALUES (null, :pseudo, :message)');
        $statement->bindParam('message', $chat->message);
        $statement->bindParam('pseudo', $chat->pseudo);
        $statement->execute();
    }
}