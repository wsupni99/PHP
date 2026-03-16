<?php
// cd C:\Users\user\Documents\PHP\03\HW\
// php -S localhost:8000 index.php
function safe(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri    = rtrim($uri, '/');
$routes = [
    'GET'  => [],
    'POST' => [],
];

$routes['GET']['/home'] = function () {
    echo '<!doctype html>';
    echo '<html lang="ru">';
    echo '<head><meta charset="UTF-8"><title>Роутер</title></head>';
    echo '<body>';
    echo '<h1>Главная</h1>';
    echo '<p>Это главная страница.</p>';
    echo '<p><a href="/form">Перейти к форме</a></p>';
    echo '</body>';
    echo '</html>';
};

$routes['GET']['/form'] = function () {
    echo '<!doctype html>';
    echo '<html lang="ru">';
    echo '<head><meta charset="UTF-8"><title>Форма</title></head>';
    echo '<body>';
    echo '<h1>Форма</h1>';
    echo '<form method="POST" action="/form">';
    echo '    <label>Имя: <input type="text" name="name" value=""></label><br><br>';
    echo '    <label>Email: <input type="email" name="email" value=""></label><br><br>';
    echo '    <button type="submit">Отправить</button>';
    echo '</form>';
    echo '</body>';
    echo '</html>';
};

$routes['POST']['/form'] = function () {
    $name  = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $name  = safe($name);
    $email = safe($email);

    echo '<!doctype html>';
    echo '<html lang="ru">';
    echo '<head><meta charset="UTF-8"><title>Результат</title></head>';
    echo '<body>';
    echo '<h1>Данные из формы</h1>';
    echo '<p><strong>Имя:</strong> ' . $name . '</p>';
    echo '<p><strong>Email:</strong> ' . $email . '</p>';
    echo '<p><a href="/form">Назад к форме</a></p>';
    echo '</body>';
    echo '</html>';
};

$routes['GET']['/about'] = function () {
    echo '<!doctype html>';
    echo '<html lang="ru">';
    echo '<head><meta charset="UTF-8"><title>О сайте</title></head>';
    echo '<body>';
    echo '<h1>О сайте</h1>';
    echo '<p>Тут есть GET и POST</p>';
    echo '<p><a href="/">На главную</a></p>';
    echo '</body>';
    echo '</html>';
};

if (!isset($routes[$method][$uri])) {
    http_response_code(404);
    echo '<!doctype html>';
    echo '<html lang="ru">';
    echo '<head><meta charset="UTF-8"><title>404</title></head>';
    echo '<body>';
    echo '<h1>404 — Страница не найдена</h1>';
    echo '<p>Маршрут не найден для метода ' . $method . '</p>';
    echo '<p><a href="/">На главную</a></p>';
    echo '</body>';
    echo '</html>';
    exit;
}

$handler = $routes[$method][$uri];
$handler();
