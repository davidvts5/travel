<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

require_once __DIR__ . '/../config/db_config.php';

$tour_id = $_GET['tour_id'] ?? null;
if (!$tour_id) {
    echo json_encode(['success'=>false, 'message'=>'Missing tour_id']);
    exit;
}

$pdo = connectDb();
$stmt = $pdo->prepare("
    SELECT a.*
    FROM tour_attractions ta
    JOIN attractions a ON ta.attraction_id = a.attraction_id
    WHERE ta.tour_id = :tour_id
");
$stmt->execute([':tour_id'=>$tour_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success'=>true, 'data'=>$data]);
