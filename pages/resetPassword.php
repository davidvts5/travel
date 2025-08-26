<?php
session_start();
require_once '../config/db_config.php';
$pdo = connectDb();

$token = $_GET['token'] ?? '';

if (!$token) {
    die("Invalid token");
}

// 1. Provera tokena
$stmt = $pdo->prepare("SELECT user_id, expires_at FROM password_reset_tokens WHERE token = :token");
$stmt->execute(['token' => $token]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || strtotime($row['expires_at']) < time()) {
    die("Invalid or expired token");
}

$user_id = $row['user_id'];

// 2. Ako je submitovana forma
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        echo "Passwords must match!!!";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // Update lozinke
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
        $stmt->execute(['password' => $hashed, 'user_id' => $user_id]);

        // Obrisi token
        $stmt = $pdo->prepare("DELETE FROM password_reset_tokens WHERE token = :token");
        $stmt->execute(['token' => $token]);

        echo "Password successfully reset! <a href='login.php'>Login</a>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<h2>Reset Password</h2>
<form method="POST">
    <label>New Password</label>
    <input type="password" name="password" required><br>
    <label>Confirm Password</label>
    <input type="password" name="confirm" required><br>
    <button type="submit">Change Password</button>
</form>
</body>
</html>
