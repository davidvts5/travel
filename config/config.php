<?php
$dotenv = parse_ini_file(__DIR__ . '/../.env');

define('DB_CONFIG', [
    'dsn' => "mysql:host={$dotenv['DB_HOST']};dbname={$dotenv['DB_NAME']};charset=utf8",
    'username' => $dotenv['DB_USER'],
    'password' => $dotenv['DB_PASS'],
]);
