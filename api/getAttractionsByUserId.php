<?php
header('Content-Type: application/json; charset=utf-8');
require '../config/db_config.php';
require '../datatables/includes/functions.php';

$agency_id = $_SESSION['user_id'];

$stmt = $GLOBALS['pdo']->prepare("
    SELECT a.name, a.description, a.date_time, c.city, c.country
    FROM attractions a
    JOIN cities c ON a.city_id = c.id
    WHERE a.agency_id = :agency_id
    ORDER BY a.date_time DESC
");
$stmt->execute(['agency_id' => $agency_id]);

$data = [];
$no = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [
        $no++,
        htmlspecialchars($row['name']),
        htmlspecialchars($row['description']),
        htmlspecialchars($row['city']),
        htmlspecialchars($row['country']),
        $row['date_time']
    ];
}

echo json_encode([
    "data" => $data
]);
