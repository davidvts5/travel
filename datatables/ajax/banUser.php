<?php
session_start();
require '../../config/db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit;
}

$pdo = connectDb();

$userId = $_POST['user_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$userId || !in_array($action, ['ban','unban'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Menja banned kolonu
$banned = ($action === 'ban') ? 1 : 0;
$stmt = $pdo->prepare("UPDATE users SET banned = :banned WHERE user_id = :user_id");
$stmt->execute([
    'banned' => $banned,
    'user_id' => $userId
]);

echo json_encode(['success' => true]);
