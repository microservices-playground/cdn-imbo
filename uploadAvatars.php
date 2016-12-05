<?php

require_once __DIR__ . '/vendor/autoload.php';

$pdo = new \PDO('mysql:dbname=foodlove;host=192.168.100.2', 'foodlove', 'foodlove');
$imbo = new \ImboClient\ImboClient('http://cdn-imbo', [
    'publicKey' => null,
    'privateKey' => null,
    'user' => 'foodlove',
]);
$mongo = new \MongoDB\Client('mongodb://imbo:imbo@192.168.100.5:27017/imbo?authMechanism=SCRAM-SHA-1');

$databaseCleanUp = new \CdnImbo\DatabaseCleanUp($pdo, $mongo);
$fixturesLoader = new \CdnImbo\FixturesLoader($pdo, $imbo);

$databaseCleanUp->databaseCleanUp();
$fixturesLoader->loadFixtures();

echo 'Upload successful' . PHP_EOL;
