<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once '../config/db_config.php';
require_once '../config/email_config.php';
$pdo = connectDb();

// Dohvati email
if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die("User not found.");
    }
    $user_id = $user['user_id'];
} else {
    $input = json_decode(file_get_contents("php://input"), true);
    $email = trim($input['email'] ?? '');
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required.");
    }
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die("No account found with that email.");
    }
    $user_id = $user['user_id'];
}

try {
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $pdo->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) 
                           VALUES (:user_id, :token, :expires_at)");
    $stmt->execute([
        'user_id' => $user_id,
        'token' => $token,
        'expires_at' => $expires
    ]);

    $resetLink = "http://localhost:63342/DavidNwp2025/pages/resetPassword.php?token=" . urlencode($token);

    // 4. Pošalji mejl
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
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset your JourneyMate password';
        $mail->Body = "
        Hi,<br><br>
        You requested a password reset. Please click 
        <a href='$resetLink'>this link</a> to set a new password.<br><br>
        If you didn’t request this, just ignore this email.<br><br>
        Thank you,<br>
        JourneyMate
    ";

        $mail->send();
        echo "Reset link sent to your email.";
    } catch (Exception $e) {
        die("Mailer Error: {$mail->ErrorInfo}");
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
