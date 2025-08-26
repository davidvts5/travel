<?php
require '../config/db_config.php';
try {
    $pdo = new PDO(DB_CONFIG['dsn'], DB_CONFIG['username'], DB_CONFIG['password']);
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}