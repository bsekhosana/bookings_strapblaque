<?php

return [

    'repo' => 'git@github.com:bsekhosana/bookings_strapblaque.git',

    'branch' => env('DEPLOYER_GIT_BRANCH', 'master'),

    'ssh_key' => env('DEPLOYER_SSH_KEY', '~/.ssh/id_ed25519'),

    'php_fpm' => env('DEPLOYER_PHP_FPM', '8.3'),

    'keep_releases' => 5,

    'servers' => [
        'staging' => [
            [
                'host' => 'staging.example.com',
                'user' => 'laravel',
                'path' => '/var/www',
                'port' => 22,
                'url'  => '',
            ],
        ],
        'production' => [
            [
                'host' => '41.76.111.100',
                'user' => 'laravel',
                'path' => '/var/www',
                'port' => 22,
                'url'  => '',
            ],
        ],
    ],

];
