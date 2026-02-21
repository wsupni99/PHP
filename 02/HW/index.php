<?php
// http://localhost:63342/PHP/02/HW/index.php?min=1000&max=10000&sort=name&dir=desc
// http://localhost:63342/PHP/02/HW/index.php?q=book&min=100&sort=price&dir=asc&page=2&perPage=3
function safe(string $s): string {
    return safe($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$products = [
    [
        'id' => 1,
        'name' => 'PHP book',
        'price' => 150,
        'tags' => ['book', 'php', 'programming'],
    ],
    [
        'id' => 2,
        'name' => 'JavaScript book',
        'price' => 200,
        'tags' => ['book', 'js'],
    ],
    [
        'id' => 3,
        'name' => 'Notebook Dell',
        'price' => 55000,
        'tags' => ['laptop', 'electronics'],
    ],
    [
        'id' => 4,
        'name' => 'iPhone',
        'price' => 90000,
        'tags' => ['phone', 'electronics'],
    ],
    [
        'id' => 5,
        'name' => 'Android phone',
        'price' => 30000,
        'tags' => ['phone', 'android'],
    ],
    [
        'id' => 6,
        'name' => 'USB cable',
        'price' => 300,
        'tags' => ['cable', 'electronics'],
    ],
    [
        'id' => 7,
        'name' => 'Power bank',
        'price' => 2500,
        'tags' => ['power', 'electronics'],
    ],
    [
        'id' => 8,
        'name' => 'Backpack',
        'price' => 1800,
        'tags' => ['bag', 'accessories'],
    ],
    [
        'id' => 9,
        'name' => 'Headphones',
        'price' => 4000,
        'tags' => ['audio', 'electronics'],
    ],
    [
        'id' => 10,
        'name' => 'Book about algorithms',
        'price' => 600,
        'tags' => ['book', 'algorithms'],
    ],
];
$q       = isset($_GET['q']) ? trim($_GET['q']) : '';
$min     = isset($_GET['min']) ? (float)$_GET['min'] : null;
$max     = isset($_GET['max']) ? (float)$_GET['max'] : null;
$sort    = isset($_GET['sort']) ? $_GET['sort'] : '';
$dir     = isset($_GET['dir']) ? strtolower($_GET['dir']) : 'asc';
$page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = isset($_GET['perPage']) ? max(1, (int)$_GET['perPage']) : 5;
$filtered = [];

foreach ($products as $product) {
    if ($q !== '') {
        $foundInName = stripos($product['name'], $q) !== false;
        $foundInTags = false;

        foreach ($product['tags'] as $tag) {
            if (stripos($tag, $q) !== false) {
                $foundInTags = true;
                break;
            }
        }

        if (!$foundInName && !$foundInTags) {
            continue;
        }
    }

    if ($min !== null && $product['price'] < $min) {
        continue;
    }

    if ($max !== null && $product['price'] > $max) {
        continue;
    }

    $filtered[] = $product;
}

// Сортировка (usort)
if ($sort === 'price' || $sort === 'name') {
    usort($filtered, function ($a, $b) use ($sort, $dir) {
        if ($a[$sort] == $b[$sort]) {
            return 0;
        }
        if ($dir === 'asc') {
            return ($a[$sort] < $b[$sort]) ? -1 : 1;
        } else {
            return ($a[$sort] > $b[$sort]) ? -1 : 1;
        }
    });
}

$totalItems  = count($filtered);
$totalPages  = $totalItems > 0 ? (int)ceil($totalItems / $perPage) : 1;
$page        = min($page, $totalPages);
$offset      = ($page - 1) * $perPage;
$pageItems   = array_slice($filtered, $offset, $perPage);

function buildUrl($params = []) {
    $base = 'index.php';
    $query = array_merge($_GET, $params);
    return $base . '?' . http_build_query($query);
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список товаров</title>
</head>
<body>

<h1>Список товаров</h1>

<p>Найдено товаров: <?= $totalItems ?></p>

<ul>
    <?php if (empty($pageItems)): ?>
        <li>По заданным фильтрам товары не найдены.</li>
    <?php else: ?>
        <?php foreach ($pageItems as $item): ?>
            <li>
                #<?= safe($item['id']) ?>
                — <?= safe($item['name']) ?>
                — <?= safe($item['price']) ?> руб.
                — теги: <?= safe(implode(', ', $item['tags'])) ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>

<hr>

<h2>Пагинация</h2>
<p>
    Страница <?= $page ?> из <?= $totalPages ?>
</p>

<?php if ($totalPages > 1): ?>
    <p>
        <?php if ($page > 1): ?>
            <a href="<?= buildUrl(['page' => 1]) ?>">Первая</a>
            <a href="<?= buildUrl(['page' => $page - 1]) ?>">Предыдущая</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="<?= buildUrl(['page' => $page + 1]) ?>">Следующая</a>
            <a href="<?= buildUrl(['page' => $totalPages]) ?>">Последняя</a>
        <?php endif; ?>
    </p>
<?php endif; ?>

</body>
</html>
