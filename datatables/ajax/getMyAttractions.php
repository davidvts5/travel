<?php
require_once '../../config/db_config.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'agency') {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit;
}

$agencyId = $_GET['agency_id'] ?? null;

if (!$agencyId) {
    echo json_encode(["success" => false, "error" => "Missing agency ID"]);
    exit;
}

try {
    $pdo = connectDb();

    $stmt = $pdo->prepare("
        SELECT a.attraction_id, a.name, a.description, a.address, a.budget, a.is_active,
               a.image_url,
               c.city AS city_name,         -- aliasirano
               co.country_name AS country_name
        FROM attractions a
        JOIN cities c ON a.city_id = c.city_id
        JOIN countries co ON c.country_id = co.country_id
        WHERE a.user_id = :agency_id
        ORDER BY a.attraction_id ASC
    ");
    $stmt->execute(['agency_id' => $agencyId]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
