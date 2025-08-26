<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Provera uloge
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'agency') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$attraction_id = $_POST['attraction_id'] ?? null;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$address = trim($_POST['address'] ?? '');
$budget = $_POST['budget'] ?? null;

if (!$attraction_id || !$name || !$description || !$address) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    $pdo = connectDb();
    $agency_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT image_url FROM attractions WHERE attraction_id = :id AND user_id = :agency_id");
    $stmt->execute(['id' => $attraction_id, 'agency_id' => $agency_id]);
    $attraction = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$attraction) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Attraction not found or unauthorized']);
        exit;
    }

    $image_url = $attraction['image_url'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExt, $allowedExts)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid image format']);
            exit;
        }

        $newFileName = 'attraction_' . $attraction_id . '.' . $fileExt;
        $destPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to upload image']);
            exit;
        }

        $image_url = '\images\\' . $newFileName;
    }

    $stmt = $pdo->prepare("
        UPDATE attractions
        SET name = :name,
            description = :description,
            address = :address,
            budget = :budget,
            image_url = :image_url,
            updated_at = NOW()
        WHERE attraction_id = :id AND user_id = :agency_id
    ");
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':address' => $address,
        ':budget' => $budget,
        ':image_url' => $image_url,
        ':id' => $attraction_id,
        ':agency_id' => $agency_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Attraction updated successfully', 'image_url' => $image_url]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
