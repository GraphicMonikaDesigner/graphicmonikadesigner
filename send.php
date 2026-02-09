<?php

    $host = "localhost";
    $db   = "form_DB";
    $user = "Check";
    $pass = "Save";

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Грешка при връзка: " . $conn->connect_error);
}

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : '';
    $logo_style = $_POST['logo_style'] ?? '';
    $card_format = $_POST['card_format'] ?? '';
    $platforms = $_POST['platforms'] ?? '';
    $description = $_POST['description'] ?? '';
    $budget = $_POST['budget'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $to = "graphic.designer.monika05@gmail.com"; 
    $subject = "Нова заявка за услуга";

    $message=
    "Име: $name
    Имейл: $email
    Услуги: $services
    Стил лого: $logo_style
    Формат визитки: $card_format
    Платформи: $platforms
    Описание: $description
    Бюджет: $budget
    ";

    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "Заявката е изпратена успешно!";
    } else {
        echo "Грешка при изпращане.";
    }
}
if (isset($_POST{"Info"})) {
    $name = $_POST["username"];
    $age = $_POST["userage"];
    echo "Изпратеното име е: $name "<br>"";
    echo "Изпратената възраст е: $age "<br>"";

}

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

header("Location: thanks.html");
exit;
?>