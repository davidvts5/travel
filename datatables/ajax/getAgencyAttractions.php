<?php
session_start();
require '../../config/db_config.php';
header('Content-Type: application/json');
error_reporting(0); // privremeno

$agency_id = $_GET['agency_id'] ?? null;

if(!$agency_id){
    echo json_encode(['data'=>[]]);
    exit;
}

$pdo = connectDb();
$stmt = $pdo->prepare("SELECT attraction_id, name, description, is_active FROM attractions WHERE user_id = :uid");
$stmt->execute(['uid'=>$agency_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['data'=>$data]);
