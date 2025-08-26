<?php
session_start();
require_once '../config/db_config.php';
$pdo = connectDb();

$token = $_GET['token'] ?? '';

if (!$token) {
    echo "Invalid verification link.";
    exit;
}

try {
    // 1. Pronađi user_id preko tokena
    $stmt = $pdo->prepare("SELECT user_id FROM email_verification_tokens WHERE token = :token");
    $stmt->execute(['token' => $token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Invalid or expired verification token.";
        exit;
    }

    $user_id = $row['user_id'];

    // 2. Postavi is_confirmed = 1 u users tabeli
    $stmt = $pdo->prepare("UPDATE users SET is_confirmed = 1 WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);

    // 3. Obriši token iz tabele
    $stmt = $pdo->prepare("DELETE FROM email_verification_tokens WHERE token = :token");
    $stmt->execute(['token' => $token]);

    echo "Your account has been confirmed! You can now <a href='login.php'>log in</a>.";
    exit;
} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
}
