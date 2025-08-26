<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/db_config.php';
use Detection\MobileDetect;

$pdo = connectDb();
$detect = new MobileDetect;

$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$deviceType = $detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Mobile') : 'Desktop';

$os = 'Unknown';
if (preg_match('/windows nt/i', $userAgent)) $os = 'Windows';
elseif (preg_match('/mac os x/i', $userAgent)) $os = 'Mac OS';
elseif (preg_match('/linux/i', $userAgent)) $os = 'Linux';
elseif (preg_match('/android/i', $userAgent)) $os = 'Android';
elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) $os = 'iOS';

$browser = 'Unknown';
if (preg_match('/chrome/i', $userAgent) && !preg_match('/edge/i', $userAgent)) $browser = 'Chrome';
elseif (preg_match('/firefox/i', $userAgent)) $browser = 'Firefox';
elseif (preg_match('/safari/i', $userAgent) && !preg_match('/chrome/i', $userAgent)) $browser = 'Safari';
elseif (preg_match('/edge/i', $userAgent)) $browser = 'Edge';
elseif (preg_match('/msie|trident/i', $userAgent)) $browser = 'IE';

$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM device_logs 
    WHERE ip = :ip AND user_agent = :user_agent AND created_at > NOW() - INTERVAL 20 MINUTE
");
$stmt->execute([
    'ip' => $ip,
    'user_agent' => $userAgent
]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    $ipData = @file_get_contents("http://ip-api.com/json/{$ip}");
    $ipData = $ipData ? json_decode($ipData, true) : [];

    $country = $ipData['country'] ?? 'Unknown';
    $region  = $ipData['regionName'] ?? 'Unknown';
    $city    = $ipData['city'] ?? 'Unknown';
    $isp     = $ipData['isp'] ?? 'Unknown';

    $insert = $pdo->prepare("
        INSERT INTO device_logs 
        (ip, device_type, os, browser, user_agent, country, region, city, isp, created_at) 
        VALUES (:ip, :device_type, :os, :browser, :user_agent, :country, :region, :city, :isp, NOW())
    ");
    $insert->execute([
        'ip' => $ip,
        'device_type' => $deviceType,
        'os' => $os,
        'browser' => $browser,
        'user_agent' => $userAgent,
        'country' => $country,
        'region' => $region,
        'city' => $city,
        'isp' => $isp
    ]);
}

header('Content-Type: application/json');
echo json_encode(['success' => true]);
