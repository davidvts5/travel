<?php
session_start();
header('Content-Type: application/json');
require '../../config/db_config.php';

$pdo = connectDb();

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Uzmi JSON input
$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if(!$name || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Provera da li postoji isti email
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
if($stmt->fetchColumn() > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists.']);
    exit;
}

// Hash lozinke
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (firstname, email, password, role, is_confirmed) VALUES (:name, :email, :password, 'agency', 1)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword
    ]);
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
