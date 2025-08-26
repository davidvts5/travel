<?php
require '../config/db_config.php';
header('Content-Type: application/json');
$pdo=connectDb();
$countryId = $_GET['country_id'] ?? null;

if ($countryId) {
    $stmt = $pdo->prepare("SELECT city_id, city FROM cities WHERE country_id = ? ORDER BY city");
    $stmt->execute([$countryId]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    http_response_code(400);
    echo json_encode(["error" => "country_id is required"]);
}
