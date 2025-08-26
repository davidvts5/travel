<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] === 'user') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$city_id = $_POST['city_id'] ?? null;
$address = trim($_POST['address'] ?? '');
$budget = $_POST['budget'] ?? null;

if (!$name || !$description || !$city_id || !$address) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Please fill in all required fields']);
    exit;
}

$image_url = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExt, $allowedExts)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid image format']);
        exit;
    }

    $newFileName = uniqid('attraction_', true) . '.' . $fileExt;
    $destPath = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to upload image']);
        exit;
    }

    $image_url = '..\images\\' . $newFileName;
}

try {
    $pdo = connectDb();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        exit;
    }
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO attractions (name, description, city_id, address, budget, image_url, user_id) 
            VALUES (:name, :description, :city_id, :address, :budget, :image_url, :user_id)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':city_id' => $city_id,
        ':address' => $address,
        ':budget' => $budget,
        ':image_url' => $image_url,
        ':user_id' => $user_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Attraction added successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
