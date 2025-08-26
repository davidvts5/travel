<?php
session_start();
require '../../config/db_config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$attractionId = $_POST['attraction_id'] ?? null;

if (!$attractionId || !is_numeric($attractionId)) {
    echo json_encode(['success' => false, 'error' => 'Invalid attraction_id']);
    exit;
}

try {
    $pdo = connectDb();

    // Proveri trenutno stanje
    $stmt = $pdo->prepare("SELECT is_active FROM attractions WHERE attraction_id = :id");
    $stmt->execute(['id' => $attractionId]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$current) {
        echo json_encode(['success' => false, 'error' => 'Attraction not found']);
        exit;
    }

    $newStatus = $current['is_active'] == 1 ? 0 : 1;

    $stmt = $pdo->prepare("UPDATE attractions SET is_active = :status WHERE attraction_id = :id");
    $stmt->execute(['status' => $newStatus, 'id' => $attractionId]);

    echo json_encode(['success' => true, 'new_status' => (int)$newStatus]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
