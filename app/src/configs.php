<?php
return [
    'db' => [
        'host' => 'db',
        'port' => 3306,
        'database' => 'agregator',
        'username' => 'root',
        'password' => 123456,
    ],
    'views' => [
        'template_dir' => '/var/www/html/src/Views/templates'
    ],
    'parser' => [
        'url' => 'http://www.radio-liga.ru/yml.php',
        'temp_file_path' => '/var/www/html/storage/catalog.xml'
    ]
];
