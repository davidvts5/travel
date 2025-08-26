<?php
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../config/db_config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$pdo = connectDb();

$tourId = $_POST['tour_id'] ?? '';
$attractionId = $_POST['attraction_id'] ?? '';
$newTourName = trim($_POST['new_tour_name'] ?? '');

if (!$attractionId) {
    echo json_encode(['success' => false, 'message' => 'Missing attraction ID']);
    exit;
}

try {
    if ($tourId === '__new__') {
        if (!$newTourName) {
            echo json_encode(['success' => false, 'message' => 'Please enter a name for the new tour']);
            exit;
        }

        $checkNameStmt = $pdo->prepare("SELECT COUNT(*) FROM tours WHERE user_id = :user_id AND tour_name = :tour_name");
        $checkNameStmt->execute([
            ':user_id' => $userId,
            ':tour_name' => $newTourName
        ]);

        if ($checkNameStmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'You already have a tour with this name.']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO tours (user_id, tour_name) VALUES (:user_id, :tour_name)");
        $stmt->execute([
            ':user_id' => $userId,
            ':tour_name' => $newTourName
        ]);
        $tourId = $pdo->lastInsertId();
    }

    $ownershipCheck = $pdo->prepare("SELECT COUNT(*) FROM tours WHERE tour_id = :tour_id AND user_id = :user_id");
    $ownershipCheck->execute([
        ':tour_id' => $tourId,
        ':user_id' => $userId
    ]);

    if ($ownershipCheck->fetchColumn() == 0) {
        echo json_encode(['success' => false, 'message' => 'You do not have permission to modify this tour.']);
        exit;
    }

    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM tour_attractions WHERE tour_id = :tour_id AND attraction_id = :attraction_id");
    $checkStmt->execute([
        ':tour_id' => $tourId,
        ':attraction_id' => $attractionId
    ]);
    if ($checkStmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'This attraction is already in the selected tour.']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO tour_attractions (tour_id, attraction_id) VALUES (:tour_id, :attraction_id)");
    $stmt->execute([
        ':tour_id' => $tourId,
        ':attraction_id' => $attractionId
    ]);

    echo json_encode(['success' => true, 'message' => 'Attraction added to tour!']);
    exit;
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
