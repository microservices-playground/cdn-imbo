<?php

use Imbo\Auth\AccessControl\Adapter\ArrayAdapter;
use Imbo\Resource;

return [
    'accessControl' => function() {
        return new ArrayAdapter([
            [
                'publicKey'  => 'I3eWxVmRkIqgVzbQH8IbqaC7OzCp2fjoKBnXdF1JGao',
                'privateKey' => 'PM1UuJB0mqqnJVcTfFegaGO2boy7wTm4hzAdedCk3PE',
                'acl' => [[
                    'resources' => Resource::getReadOnlyResources(),
                    'users' => ['foodlove-r']
                ]]
            ],
            [
                'publicKey'  => 'M1IS5ievWU8lrw5zSleYTbdTzgVbFEsPbMBbiRrlExk',
                'privateKey' => 'VIn3jjlR6NIc9qEdLgTU6yATdBG5hurbmDTNwTanAU0',
                'acl' => [[
                    'resources' => Resource::getReadWriteResources(),
                    'users' => ['foodlove-rw']
                ]]
            ]
        ]);
    }
];
