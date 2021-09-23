<?php

require __DIR__.'/../vendor/autoload.php';

$route = $_SERVER['REQUEST_URI'] ?? '';
$routes = require __DIR__ . '/../src/routes.php';

$isRouteFound = false;

foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    http_response_code(404);
    echo 'Страница не найдена!';
    return;
}

unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();

//Вызываем метод контроллера и передаем в него аргументы
$controller->$actionName(...$matches);
