<?php
// Omogućava pristup sa bilo kog domena (samo za test/razvoj)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Ako je OPTIONS request (preflight), odmah vrati 200
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');
require_once ('../config/db_config.php');

$pdo = connectDb();

$name     = $_GET['name']     ?? '';
$country  = $_GET['country']  ?? '';
$city     = $_GET['city']     ?? '';
$rating   = $_GET['rating']   ?? '';
$budget   = $_GET['budget']   ?? '';


if (!empty($name)) {
    try {
        $stmt = $pdo->prepare("INSERT INTO search_logs (term, count) VALUES (?, 1) 
                               ON DUPLICATE KEY UPDATE count = count + 1");
        $stmt->execute([$name]);
    } catch (PDOException $e) {
        error_log("Search log error: " . $e->getMessage());
    }
}


$sql = "SELECT a.attraction_id, a.name, a.description, a.image_url,
               c.city, co.country_name AS country
        FROM attractions a
        JOIN cities c ON a.city_id = c.city_id
        JOIN countries co ON c.country_id = co.country_id
        WHERE a.is_active = 1";

$params = [];

if (!empty($name)) {
    $sql .= " AND a.name LIKE ?";
    $params[] = "%$name%";
}
if (!empty($country)) {
    $sql .= " AND co.country_id = ?";
    $params[] = $country;
}
if (!empty($city)) {
    $sql .= " AND c.city_id = ?";
    $params[] = $city;
}
if (!empty($rating)) {
    $sql .= " AND a.rating = ?";
    $params[] = $rating;
}
if (!empty($budget)) {
    $sql .= " AND a.budget = ?";
    $params[] = $budget;
}

$sql .= " ORDER BY a.name";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //popularnost trazenih termina
    $popularStmt = $pdo->query("SELECT term, count FROM search_logs ORDER BY count DESC LIMIT 10");
    $popularSearches = $popularStmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $attractions,
        'popular_searches' => $popularSearches
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
