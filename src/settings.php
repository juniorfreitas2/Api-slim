<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../template/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ]
    ],
];