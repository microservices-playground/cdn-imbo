<?php

require_once __DIR__ . '/vendor/autoload.php';

$pdo = new \PDO('mysql:dbname=foodlove;host=192.168.100.2', 'foodlove', 'foodlove');
$imbo = new ImboClient\ImboClient('http://cdn-imbo', [
    'publicKey' => null,
    'privateKey' => null,
    'user' => 'foodlove',
]);

$imboAvatarParameter = $pdo->query('SELECT id FROM parameters p WHERE p.name = "avatar_imbo"', \PDO::FETCH_ASSOC);
$row = $imboAvatarParameter->fetch();

if (false !== $row) {
    $imboAvatarParameterId = $row['id'];

    $statement = $pdo->prepare('DELETE FROM users_parameters WHERE parameter_id = :imboParameterId');
    $statement->execute([':imboParameterId' => $imboAvatarParameterId]);

    $statement = $pdo->prepare('DELETE FROM parameters WHERE id = :imboParameterId');
    $statement->execute([':imboParameterId' => $imboAvatarParameterId]);

    $pdo->query('INSERT INTO parameters (parameters.name, parameters.description) VALUES ("avatar_imbo", "Avatar uploaded to imbo")');
    $imboAvatarParameterId = $pdo->lastInsertId();

    $files = glob('/tmp/avatars/*');

    foreach ($files as $path) {
        $filename = basename($path);

        $statement = $pdo->prepare('SELECT user_id FROM users_parameters up WHERE up.parameter_id = 4 AND up.value = :filename');
        $statement->execute([':filename' => $filename]);
        $row = $statement->fetch();

        if (isset($row['user_id'])) {
            $response = $imbo->addImage($path);

            $statement = $pdo->prepare('INSERT INTO users_parameters (users_parameters.user_id, users_parameters.parameter_id, users_parameters.value) VALUES (:userId, :parameterId, :val)');
            $result = $statement->execute([
                'userId' => $row['user_id'],
                'parameterId' => $imboAvatarParameterId,
                'val' => $response['imageIdentifier']
            ]);

            echo sprintf('Uploaded. Image identifier: %s' . PHP_EOL, $response['imageIdentifier']);
        }
    }
}

echo 'Upload successful' . PHP_EOL;
