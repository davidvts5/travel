<?php
session_start();
require_once '../config/db_config.php';
$pdo = connectDb();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tourId = $_POST['tour_id'] ?? null;
    $attractionId = $_POST['attraction_id'] ?? null;
    $userId = $_SESSION['user_id'];

    if (!$tourId || !$attractionId) {
        die("Invalid request");
    }

    // Proveri da li tour pripada useru
    $stmt = $pdo->prepare("SELECT 1 FROM tours WHERE tour_id = ? AND user_id = ?");
    $stmt->execute([$tourId, $userId]);
    if (!$stmt->fetch()) {
        die("Not allowed");
    }

    // Obriši atrakciju iz ture
    $stmt = $pdo->prepare("DELETE FROM tour_attractions WHERE tour_id = ? AND attraction_id = ?");
    $stmt->execute([$tourId, $attractionId]);

    header("Location: ../pages/tour_details.php?tour_id=" . urlencode($tourId));
    exit;
}
