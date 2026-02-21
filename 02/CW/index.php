<!-- http://localhost:3000/?name=Ivan&role=dev&skills=1,2,3 -->
<?php
// хелпер для экранирования
function safe(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$name = $_GET['name'] ?? 'Гость';
$role = $_GET['role'] ?? 'Неизвестно';
$skills = $_GET['skills'] ?? '';

$skillsArray = explode(',', $skills);

foreach ($skillsArray as $key => $value) {
    $skillsArray[$key] = trim($value);
}
?>

<!doctype html>
<html lang="ru">
<head>  
    <meta charset="utf-8">
    <title><?= safe($name) ?></title>
</head>
<body>
    <h1><?= safe($name) ?>, <?= safe($role) ?></h1>
    
    <?php if (!empty($skillsArray)): ?>
        <h2>Навыки:</h2>
        <ul>
        <?php foreach ($skillsArray as $skill): ?>
            <?php if ($skill !== ''): ?>
                <li><?= safe($skill) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
        <p>Навыки не указаны</p>
    <?php endif; ?>
</body>
</html>
