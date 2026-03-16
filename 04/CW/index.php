<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(16));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if ($_POST['token'] !== $_SESSION['token']) {
        $_SESSION['error'] = 'Неверный токен';
        header('Location: /');
        exit;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Неверный email';
        header('Location: /');
        exit;
    }

    $_SESSION['success'] = 'Регистрация успешна!';
    header('Location: /');
    exit;
}
?>

<form action="" method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <br>
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
    <button type="submit">Зарегистрироваться</button>
</form>

<?php
// Flash сообщения
if ($_SESSION['error']) {
    echo '<p style="color:red">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
if ($_SESSION['success']) {
    echo '<p style="color:green">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
?>
