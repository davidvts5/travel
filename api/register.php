<?php
session_start();

require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../config/email_config.php';
require '../vendor/autoload.php'; // za PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$pdo = connectDb();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

$firstname = trim($data['firstname'] ?? '');
$lastname = trim($data['lastname'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$password_confirm = $data['password_confirm'] ?? '';

if (!$firstname || !$lastname || !$email || !$password || !$password_confirm) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

if ($password !== $password_confirm) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
    exit;
}

try {
    // Provera da li već postoji email
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Email is already registered.']);
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Ubaci korisnika sa is_confirmed = 0
    $insert = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password, is_confirmed) VALUES (:firstname, :lastname, :email, :password, 0)");
    $insert->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':email' => $email,
        ':password' => $password_hash,
    ]);

    $user_id = $pdo->lastInsertId();

    // Kreiraj token za potvrdu mejla
    $token = bin2hex(random_bytes(16));

    $stmt = $pdo->prepare("INSERT INTO email_verification_tokens (user_id, token) VALUES (:user_id, :token)");
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);

    // Pošalji mejl sa linkom
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_CONFIG['host'];
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_CONFIG['user'];
        $mail->Password = SMTP_CONFIG['pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = SMTP_CONFIG['port'];

        $mail->setFrom(SMTP_CONFIG['from'], SMTP_CONFIG['from_name']);
        $mail->addAddress($email, $firstname . ' ' . $lastname);

        $mail->isHTML(true);
        $mail->Subject = 'Confirm your JourneyMate account';
        $verificationLink = "http://localhost:63342/DavidNwp2025/api/verify.php?token=$token";

        $mail->Body = "Hi $firstname,<br><br>Please confirm your account by clicking <a href='$verificationLink'>this link</a>.<br><br>Thank you!";
        $mail->send();

        echo json_encode(['success' => true, 'message' => 'Registration successful! Please check your email to confirm your account.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
