<?php
require_once 'config.php';
session_start();
// Проверка авторизации
if (isset($_COOKIE['session_id'])) {
    $session_id = $_COOKIE['session_id'];
    $name = $_COOKIE['name'];
    $photo = $_COOKIE['photo'];
    $birthdate = $_COOKIE['birthdate'];

} else {
    // Кука не установлена, перенаправляем на страницу авторизации
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['message_displayed'])) {
    $_SESSION['message_displayed'] = true;
    $display_message = true;
} else {
    $display_message = false;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Профиль</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Профиль</h1>
    <div class="profile">
        <img class="avatar" src="img/<?= $photo; ?>" alt="Фото профиля">
        <p>Имя: <?= $name; ?></p>
        <p>Дата рождения: <?= $birthdate; ?></p>
    </div>
    <form action="logout.php" method="post">
        <button type="submit">Выйти</button>
    </form>
    <? if ($display_message): ?>
        <div id="popup" class="popup">
            <div class="popup_content">
                <span id="popup_close" class="popup_close">&times;</span>
                <p>Вы успешно авторизованы!</p>
                <p>Имя пользователя: <?= $name ?></p>
            </div>
        </div>
    <? endif; ?>
    <script src="script.js"></script>
</div>
</body>
</html>
