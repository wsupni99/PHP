<!-- 
 ?name=Ivan&role=admin 
 http://127.0.0.1:8042/?name=Ivan&role=admin
 -->
 
<!DOCTYPE html>
<html>
<head>
    <title>Страница профиля</title>
</head>

<body>
    <?php
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $role = isset($_GET['role']) ? $_GET['role'] : '';

    if ($role === 'admin') {
        echo 'Добрый день, админ ' . htmlspecialchars($name);
    } else {
        echo 'Добрый день, ' . htmlspecialchars($name);
    }
    ?>

    <p>Метод:
        <?php
        echo htmlspecialchars($_SERVER['REQUEST_METHOD']);
        ?>
    </p>
    <p>Полный URI:
        <?php
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $http = 'https://';
        } else {
            $http = 'http://';
        }
        echo htmlspecialchars($http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        ?>
    </p>
</body>

</html>