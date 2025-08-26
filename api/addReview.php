<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db_config.php';

$input = json_decode(file_get_contents('php://input'), true);

$userId = $input['user_id'] ?? null;
$attractionId = $input['attraction_id'] ?? null;
$comment = trim($input['comment'] ?? '');
$rating = $input['rating'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if (!$attractionId || !$comment || !$rating) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5']);
    exit;
}

$pdo = connectDb();

try {
    $stmt = $pdo->prepare("INSERT INTO comments (user_id, attraction_id, comment, rating) VALUES (:user_id, :attraction_id, :comment, :rating)");
    $stmt->execute([
        ':user_id' => $userId,
        ':attraction_id' => $attractionId,
        ':comment' => $comment,
        ':rating' => $rating
    ]);

    echo json_encode(['success' => true, 'message' => 'Review added successfully']);
    exit;

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
