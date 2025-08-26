<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db_config.php';

$pdo = connectDb();

// uzimamo user_id iz GET parametra
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "Missing user_id"
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT tour_id, tour_name FROM tours WHERE user_id = :user_id ORDER BY tour_id DESC");
    $stmt->execute([':user_id' => $user_id]);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $tours
    ]);
    exit;
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
    exit;
}
