<?php
require '../config/db_config.php';
header('Content-Type: application/json');
$pdo=connectDb();
$stmt = $pdo->query("SELECT country_id, country_name FROM countries ORDER BY country_name");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
