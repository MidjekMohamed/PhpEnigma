<?php

declare(strict_types=1);

require_once ('src/Database/Connector.php');

$pdo = \src\Database\Connector::getPDO();

$pdo->query(' 
        CREATE TABLE IF NOT EXISTS `utilisateur`(
            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `pseudo` VARCHAR NOT NULL,
            `mdpasse` VARCHAR NOT NULL 
        )')->execute();