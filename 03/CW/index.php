<?php
$routes = [
    '/' => function () {
        echo "<h1>Главная страница</h1>";
    },
    '/about' => function () {
        echo "<h1>О сайте что-то</h1>";
    },
    '/users' => function () {
        echo "<h1>Список пользователей</h1>";
        echo "<ul>
                <li>Пользователь 1</li>
                <li>Пользователь 2</li>
              </ul>";
    },
    '/home' => function () {
        echo "<h1>Домашняя страница</h1>";
    },
];

// без домена и параметров
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!isset($routes[$uri])) {
    http_response_code(404);
    echo "<h1>404 - Страница не найдена</h1>";
    exit;
}
$handler = $routes[$uri];
$handler();
