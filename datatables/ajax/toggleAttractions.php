<?php
session_start();
require '../../config/db_config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$agencyId = $_POST['agency_id'] ?? null;
if (!$agencyId) {
    echo json_encode(['success' => false, 'error' => 'Missing agency_id']);
    exit;
}

try {
    $pdo = connectDb();

    // Dohvati trenutni status iz users.attractions_enabled
    $stmt = $pdo->prepare("SELECT attractions_enabled FROM users WHERE user_id = :id");
    $stmt->execute(['id' => $agencyId]);
    $agency = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$agency) {
        echo json_encode(['success' => false, 'error' => 'Agency not found']);
        exit;
    }

    $newStatus = $agency['attractions_enabled'] ? 0 : 1;

    // Update users
    $stmt = $pdo->prepare("UPDATE users SET attractions_enabled = :status WHERE user_id = :id");
    $stmt->execute(['status' => $newStatus, 'id' => $agencyId]);

    // Bulk update svih atrakcija
    $stmt = $pdo->prepare("UPDATE attractions SET is_active = :status WHERE user_id = :id");
    $stmt->execute(['status' => $newStatus, 'id' => $agencyId]);

    echo json_encode([
        'success' => true,
        'status' => $newStatus ? 'enabled' : 'disabled'
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
