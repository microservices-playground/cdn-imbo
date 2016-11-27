<?php

return [
    'database' => function() {
        return new Imbo\Database\Mongo([
            'databaseName' => 'imbo',
            'server' => 'mongodb://imbo:imbo@192.168.100.5:27017/imbo?authMechanism=SCRAM-SHA-1'
        ]);
    }
];
