<?php

return [
    'storage' => function() {
        return new Imbo\Storage\Filesystem([
            'dataDir' => '/srv/cdn_imbo/storage',
        ]);
    }
];
