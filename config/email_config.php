<?php
$dotenv = parse_ini_file(__DIR__ . '/../../.env');

define('SMTP_CONFIG', [
    'host' => $dotenv['SMTP_HOST'] ?? 'smtp.gmail.com',
    'port' => $dotenv['SMTP_PORT'] ?? 465,
    'user' => $dotenv['SMTP_USER'] ?? '',
    'pass' => $dotenv['SMTP_PASS'] ?? '',
    'from' => $dotenv['SMTP_FROM'] ?? '',
    'from_name' => $dotenv['SMTP_FROM_NAME'] ?? 'MyApp',
]);