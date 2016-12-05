<?php

namespace CdnImbo;

use ImboClient\ImboClient;

class FixturesLoader
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var ImboClient
     */
    private $imboClient;

    /**
     * @param \PDO       $pdo
     * @param ImboClient $imboClient
     */
    public function __construct(\PDO $pdo, ImboClient $imboClient)
    {
        $this->pdo = $pdo;
        $this->imboClient = $imboClient;
    }

    public function loadFixtures()
    {
        $this->pdo->query('INSERT INTO parameters (parameters.name, parameters.description) VALUES ("avatar_imbo", "Avatar uploaded to imbo")');
        $imboAvatarParameterId = $this->pdo->lastInsertId();

        $files = glob('/tmp/avatars/*');

        foreach ($files as $path) {
            $filename = basename($path);

            $statement = $this->pdo->prepare('SELECT user_id FROM users_parameters up WHERE up.parameter_id = 4 AND up.value = :filename');
            $statement->execute(['filename' => $filename]);
            $row = $statement->fetch();

            if (!isset($row['user_id'])) {
                continue;
            }

            $response = $this->imboClient->addImage($path);

            $statement = $this->pdo->prepare('INSERT INTO users_parameters (users_parameters.user_id, users_parameters.parameter_id, users_parameters.value) VALUES (:userId, :parameterId, :val)');
            $result = $statement->execute([
                'userId' => $row['user_id'],
                'parameterId' => $imboAvatarParameterId,
                'val' => $response['imageIdentifier']
            ]);

            if (true === $result) {
                echo sprintf('Uploaded. Image identifier: %s' . PHP_EOL, $response['imageIdentifier']);
            } else {
                echo sprintf('Not uploaded. Issue: %s' . PHP_EOL, implode(PHP_EOL, $statement->errorInfo()));
            }
        }
    }
}
