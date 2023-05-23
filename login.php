<?
require_once 'config.php';
session_start();

// Проверка логина и пароля
$user_name = $_POST['username'];
$password = $_POST['password'];

if (isset($_SESSION['blocked_time']) && $_SESSION['blocked_time'] > time()) {
    http_response_code(429);
    $remaining_time = $_SESSION['blocked_time'] - time();
    echo "Слишком много неудачных попыток. Попробуйте снова через " . gmdate("i:s", $remaining_time) . ".";;
    exit();
}

// Подключение к базе данных
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Запрос на получение пользователя
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if (password_verify($password, $hashed_password)) {
        // Успешная авторизация

        // Генерируем уникальный идентификатор сессии
        $session_id = uniqid();

        setcookie('session_id', $session_id, time() + 3600);
        setcookie('name', $row['username'], time() + 3600);
        setcookie('photo', $row['photo'], time() + 3600);
        setcookie('birthdate', $row['birthdate'], time() + 3600);

        http_response_code(200);
    } else {

        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
        } else {
            $_SESSION['login_attempts']++;
        }

        // Проверяем счетчик неудачных попыток
        if ($_SESSION['login_attempts'] >= 3) {
            // Блокируем аккаунт на 5 минут
            $_SESSION['blocked_time'] = time() + (5 * 60);

            http_response_code(429);
            echo "Слишком много неудачных попыток. Попробуйте снова через 5 минут.";
        } else {
            http_response_code(401);
            echo "Неправильный пароль";
        }
    }
} else {
    http_response_code(401);
    echo "Неправильное имя пользователя";
}
// Закрываем соединение с базой данных
$stmt->close();
$conn->close();

?>