<?php
header('Content-Type: application/json; charset=utf-8');
require '../../config/db_config.php';

$pdo = connectDb();

// Uzmi sve korisnike
$stmt = $pdo->query("SELECT user_id, firstname, lastname, email, role, banned FROM users ORDER BY user_id ASC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = [];
$number = 1;
foreach ($users as $u) {
    $data[] = [
        $u['user_id'],             // user_id za dugme
        $u['firstname'],
        $u['lastname'],
        $u['email'],
        $u['role'],
        $u['banned'] ? 'banned' : 'active'  // status za render dugmeta
    ];
    $number++;
}

echo json_encode([
    "draw" => 1,
    "recordsTotal" => count($data),
    "recordsFiltered" => count($data),
    "data" => $data
]);
