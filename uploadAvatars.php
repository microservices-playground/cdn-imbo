<?php

$pdo = new \PDO('mysql:dbname=foodlove;host=192.168.100.2', 'foodlove', 'foodlove');
$imboAvatarParameter = $pdo->query('SELECT id FROM parameters p WHERE p.name = "avatar_imbo"', \PDO::FETCH_ASSOC);

$row = $imboAvatarParameter->fetch();

if (false !== $row) {
    $imboAvatarParameterId = $row['id'];

    $query = 'DELETE FROM users_parameters WHERE users_parameters.parameter_id = :imboParameterId';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':imboParameterId', $imboAvatarParameterId, PDO::PARAM_INT);
    $statement->execute();

    $query = 'DELETE FROM parameters WHERE parameters.id = :imboParameterId';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imboParameterId', $imboAvatarParameterId, PDO::PARAM_INT);
    $statement->execute();

    $pdo->query('INSERT INTO parameters (parameters.name, parameters.description) VALUES ("avatar_imbo", "Avatar uploaded to imbo")');
    $imboAvatarParameterId = $pdo->lastInsertId();
}

echo 'ok';
