<?php
// db_config.php
require_once 'config.php';

function connectDb() {
    $dbConfig = DB_CONFIG;

    try {
        $pdo = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}
