<?php

$host = "localhost";
$db   = "your_database_name";
$user = "your_db_user";
$pass = "your_db_password";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Грешка при връзка");
}

$sql = "SELECT * FROM service_requests ORDER BY created_at DESC";
$result = $conn->query($sql);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=zayavki.csv');

echo "\xEF\xBB\xBF";

$output = fopen("php://output", "w");

fputcsv($output, [
    'ID',
    'Име',
    'Имейл',
    'Услуги',
    'Стил лого',
    'Формат визитки',
    'Платформи',
    'Описание',
    'Бюджет',
    'Дата'
]);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['email'],
        $row['services'],
        $row['logo_style'],
        $row['card_format'],
        $row['platforms'],
        $row['description'],
        $row['budget'],
        $row['created_at']
    ]);
}

if (!isset($_GET['key']) || $_GET['key'] !== 'SECRET123') {
    die("Нямаш достъп");
}

fclose($output);
$conn->close();
exit;