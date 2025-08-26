<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Rukovanje preflight zahtevom
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/db_config.php';
$pdo = connectDb();

// Uzmi JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

// Validacija
if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

try {
    // Uzmi korisnika iz baze
    $stmt = $pdo->prepare("SELECT user_id, firstname,email, password, role, is_confirmed, banned FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ako korisnik ne postoji ili lozinka nije ta??na
    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'Incorrect email or password.']);
        exit;
    }

    // Provera da li je banovan
    if (!empty($user['banned']) && $user['banned'] == 1) {
        echo json_encode(['success' => false, 'message' => 'Your account is banned.']);
        exit;
    }

    // Provera da li je email potvr??en
    if ($user['is_confirmed'] != 1) {
        echo json_encode(['success' => false, 'message' => 'Please confirm your email before logging in.']);
        exit;
    }

    // Postavi sesiju
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_firstname'] = $user['firstname'];
    $_SESSION['user_role'] = $user['role'];

    ob_clean();
    echo json_encode([
        'success' => true,
        'message' => 'Login successful!',
        'user' => [
            'user_id' => $user['user_id'],
            'firstname' => $user['firstname'],
            'email' => $user['email'],
            'role' => $user['role']
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}