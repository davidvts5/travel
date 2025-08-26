<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
require_once '../config/db_config.php';
$pdo = connectDb();

$ip = $_SERVER['REMOTE_ADDR'];

$stmt = $pdo->prepare("SELECT country FROM device_logs WHERE ip = :ip ORDER BY created_at DESC LIMIT 1");
$stmt->execute(['ip' => $ip]);
$country = $stmt->fetchColumn();

echo json_encode([
    'success' => true,
    'country' => $country ?? 'Unknown'
]);
