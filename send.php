<?php
// --- Настройки за базата ---
$host = "localhost";
$db   = "form_DB";
$user = "Check";
$pass = "Save";

// Свързване с базата
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

// Проверка за грешка при връзка
if ($conn->connect_error) {
    die("Грешка при връзка: " . $conn->connect_error);
}

// --- Вземане на данни от формата ---
$name        = $_POST['name'] ?? '';
$email       = $_POST['email'] ?? '';
$services    = isset($_POST['services']) ? implode(", ", $_POST['services']) : '';
$logo_style  = $_POST['logo_style'] ?? '';
$card_format = $_POST['card_format'] ?? '';
$platforms   = $_POST['platforms'] ?? '';
$description = $_POST['description'] ?? '';
$budget      = $_POST['budget'] ?? '';

// --- Изпращане на имейл ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to      = "graphic.designer.monika05@gmail.com";
    $subject = "Нова заявка за услуга";

    $message = "Име: $name
Имейл: $email
Услуги: $services
Стил лого: $logo_style
Формат визитки: $card_format
Платформи: $platforms
Описание: $description
Бюджет: $budget
";

    $headers = "From: $email";

    if (!mail($to, $subject, $message, $headers)) {
        echo "Грешка при изпращане на имейл.";
        exit;
    }
}

// --- Пример за debug на допълнителна информация ---
if (isset($_POST["Info"])) {
    $username = $_POST["username"] ?? '';
    $userage  = $_POST["userage"] ?? '';
    echo "Изпратеното име е: $username<br>";
    echo "Изпратената възраст е: $userage<br>";
}

// --- Запис в базата ---
$stmt = $conn->prepare("
    INSERT INTO service_requests
    (name, email, services, logo_style, card_format, platforms, description, budget)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssss",
    $name,
    $email,
    $services,
    $logo_style,
    $card_format,
    $platforms,
    $description,
    $budget
);

$stmt->execute();
$stmt->close();
$conn->close();

// --- Пренасочване към страница за благодарност ---
header("Location: thanks.html");
exit;
?>
