<?php
require_once 'Product.php';

// Массив товаров
$productsData = [
    [1, 'Телефон Яблоко', 89990.50],
    [2, 'Телефон Груша', 129999.00],
    [3, 'Планшет Лимон', 4545490.75]
];

// Создаем объекты Product в цикле
$products = [];
foreach ($productsData as $data) {
    $products[] = new Product($data[0], $data[1], $data[2]);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
</head>
<body>
<h1>Каталог товаров</h1>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Цена</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product->getId() ?></td>
            <td><?= htmlspecialchars($product->getTitle()) ?></td>
            <td><?= $product->getFormattedPrice() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
