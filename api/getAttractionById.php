<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Rukovanje preflight zahtevom
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once '../config/db_config.php';

$pdo = connectDb();

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Missing attraction ID'
    ]);
    exit;
}

$attraction_id = (int)$_GET['id'];

try {
    $sql = "SELECT a.*, ci.city, co.country_name AS country
            FROM attractions a
            JOIN cities ci ON a.city_id = ci.city_id
            JOIN countries co ON ci.country_id = co.country_id
            WHERE a.attraction_id = :id AND a.is_active = 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $attraction_id]);
    $attraction = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$attraction) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'Attraction not found'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'data' => $attraction
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
