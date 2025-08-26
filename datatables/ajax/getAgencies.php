<?php
header('Content-Type: application/json; charset=utf-8');
require '../../config/db_config.php'; // prilagodi putanju do tvoje db konekcije

$pdo = connectDb();

try {
    // Uzmi sve korisnike koji su agencije
    $stmt = $pdo->query("SELECT user_id, firstname, email FROM users WHERE role='agency' ORDER BY user_id ASC");
    $agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "data" => $agencies
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "data" => [],
        "error" => $e->getMessage()
    ]);
}