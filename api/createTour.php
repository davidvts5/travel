<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once '../config/db_config.php';

$response = ['success' => false, 'message' => 'Unknown error'];

if (!isset($_SESSION['user_id']) || empty($_POST['tour_name'])) {
    $response['message'] = 'User not logged in or tour name missing';
    echo json_encode($response);
    exit;
}

$pdo = connectDb();
$tourName = trim($_POST['tour_name']);
$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tours WHERE user_id = :user_id AND tour_name = :tour_name");
    $stmt->execute(['user_id' => $userId, 'tour_name' => $tourName]);
    if ($stmt->fetchColumn() > 0) {
        $response['message'] = 'You already have a tour with that name.';
        echo json_encode($response);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO tours (user_id, tour_name) VALUES (:user_id, :tour_name)");
    $stmt->execute(['user_id' => $userId, 'tour_name' => $tourName]);

    $response['success'] = true;
    $response['message'] = 'Tour created successfully!';
    $response['tour_id'] = $pdo->lastInsertId();

    echo json_encode($response);
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
    echo json_encode($response);
}
