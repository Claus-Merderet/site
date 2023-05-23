<?php
session_start();
// Удаление данных сессии
session_destroy();


// Удаление куки
setcookie('session_id', '', time() - 3600);
setcookie('name', '', time() - 3600);
setcookie('photo', '', time() - 3600);
setcookie('birthdate', '', time() - 3600);

// Редирект на страницу авторизации
header("Location: index.php");
exit();
?>
