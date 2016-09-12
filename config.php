<?php
return [
    'define' => [
        'DS' => '/',
        'SITE_PATH' => function () {
            return str_replace(DIRECTORY_SEPARATOR, DS, realpath(dirname(__FILE__) . DS) . DS);
        },
        'DEFAULT_SHIPPING' => 3,
        'DEMO' => 1,
    ],
    'ini_set' => [
        'display_errors' => 'On',
        'mysql.connect_timeout' => 60
    ],
    'setlocale' => [LC_ALL, 'en_US'],
    'date_default_timezone_set' => ['UTC'],
    'DBS' => [
        'connections' => [
            'default' => [
                'connection' => "localhost",
                'user' => "root",
                'password' => "",
                'db' => ['iluvfabrix']
            ]
        ]
    ],
    'layouts' => "first_layouts",
];
