<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Авторизация</h1>
    <form id="login_form" autocomplete="off">
        <div class="form_group">
            <input type="text" id="username" name="username" placeholder="Логин" required>
        </div>
        <div class="form_group">
            <input type="password" id="password" name="password" placeholder="Пароль" required>
        </div>
        <div class="form_group">
            <button type="submit">Войти</button>
        </div>
        <p id="error_message"></p>
    </form>
</div>
<script src="script.js"></script>
</body>
</html>
