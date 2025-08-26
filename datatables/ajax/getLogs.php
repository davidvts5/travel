<?php
require_once '../../config/db_config.php';
$pdo = connectDb();

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM device_logs ORDER BY created_at DESC");
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "data" => $logs
    ]);
} catch (Exception $e) {
    echo json_encode([
        "data" => [],
        "error" => $e->getMessage()
    ]);
}
