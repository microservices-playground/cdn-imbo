<?php

namespace CdnImbo;

use MongoDB\Client;

class DatabaseCleanUp
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var Client
     */
    private $mongoClient;

    /**
     * @param \PDO   $pdo
     * @param Client $mongoClient
     */
    public function __construct(\PDO $pdo, Client $mongoClient)
    {
        $this->pdo = $pdo;
        $this->mongoClient = $mongoClient;
    }

    /**
     * @return void
     */
    public function databaseCleanUp()
    {
        $collection = $this->mongoClient->selectCollection('imbo', 'image');
        $collection->drop();

        $this->pdo->query('DELETE FROM users_parameters WHERE parameter_id > 10');
        $this->pdo->query('DELETE FROM parameters WHERE id > 10');
    }
}
