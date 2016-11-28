<?php

return [
    'accessControl' => function() {
        return new Imbo\Auth\AccessControl\Adapter\SimpleArrayAdapter([
            'foodlove' => 'I3eWxVmRkIqgVzbQH8IbqaC7OzCp2fjoKBnXdF1JGao',
        ]);
    },
    'database' => function() {
        return new Imbo\Database\Mongo([
            'databaseName' => 'imbo',
            'server' => 'mongodb://imbo:imbo@192.168.100.5:27017/imbo?authMechanism=SCRAM-SHA-1'
        ]);
    },
    'storage' => function() {
        return new Imbo\Storage\Filesystem([
            'dataDir' => '/srv/cdn_imbo/storage',
        ]);
    },
    'eventListeners' => [
        'accessToken' => null,
        'auth' => null
    ],
];
