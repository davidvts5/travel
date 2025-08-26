<?php
session_start();
require_once '../config/db_config.php';
$pdo = connectDb();

header('Content-Type: application/json');

// ✅ Provera da li je admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ["success" => false, "message" => "Unknown error"];

    try {
        switch ($action) {
            case 'add_country':
                $name = trim($_POST['country_name']);
                if (!empty($name)) {
                    $stmt = $pdo->prepare("INSERT INTO countries (country_name) VALUES (?)");
                    $stmt->execute([$name]);
                    $newId = $pdo->lastInsertId();
                    http_response_code(201);
                    $response = ["success" => true, "message" => "Country added", "new_id" => $newId];
                } else {
                    http_response_code(400);
                    $response = ["success" => false, "message" => "Country name is required"];
                }
                break;

            case 'add_city':
                $cityName = trim($_POST['city_name']);
                $countryId = intval($_POST['city_country']);
                if (!empty($cityName) && $countryId > 0) {
                    $stmt = $pdo->prepare("INSERT INTO cities (city, country_id) VALUES (?, ?)");
                    $stmt->execute([$cityName, $countryId]);
                    $newId = $pdo->lastInsertId();
                    http_response_code(201);
                    $response = ["success" => true, "message" => "City added", "new_id" => $newId];
                } else {
                    http_response_code(400);
                    $response = ["success" => false, "message" => "City name and country are required"];
                }
                break;

            case 'delete_country':
                $id = intval($_POST['id']);
                if ($id > 0) {
                    $stmt = $pdo->prepare("DELETE FROM countries WHERE country_id = ?");
                    $stmt->execute([$id]);
                    http_response_code(200);
                    $response = ["success" => true, "message" => "Country deleted"];
                } else {
                    http_response_code(400);
                    $response = ["success" => false, "message" => "Invalid country ID"];
                }
                break;

            case 'delete_city':
                $id = intval($_POST['id']);
                if ($id > 0) {
                    $stmt = $pdo->prepare("DELETE FROM attractions WHERE city_id = ?");
                    $stmt->execute([$id]);

                    $stmt = $pdo->prepare("DELETE FROM cities WHERE city_id = ?");
                    $stmt->execute([$id]);

                    http_response_code(200);
                    $response = ["success" => true, "message" => "City and its attractions deleted"];
                } else {
                    http_response_code(400);
                    $response = ["success" => false, "message" => "Invalid city ID"];
                }
                break;

            case 'edit_country':
                $id = intval($_POST['id']);
                $name = trim($_POST['country_name']);
                if($id > 0 && !empty($name)){
                    $stmt = $pdo->prepare("UPDATE countries SET country_name = ? WHERE country_id = ?");
                    $stmt->execute([$name, $id]);
                    $response = ["success" => true, "message" => "Country updated"];
                } else {
                    $response = ["success" => false, "message" => "Invalid input"];
                }
                break;

            case 'edit_city':
                $id = intval($_POST['id']);
                $name = trim($_POST['city_name']);
                $countryId = intval($_POST['city_country']);
                if($id > 0 && !empty($name) && $countryId > 0){
                    $stmt = $pdo->prepare("UPDATE cities SET city = ?, country_id = ? WHERE city_id = ?");
                    $stmt->execute([$name, $countryId, $id]);
                    $response = ["success" => true, "message" => "City updated"];
                } else {
                    $response = ["success" => false, "message" => "Invalid input"];
                }
                break;

            default:
                http_response_code(400);
                $response = ["success" => false, "message" => "Invalid action"];
                break;
        }
    } catch (Exception $e) {
        http_response_code(500);
        $response = ["success" => false, "message" => $e->getMessage()];
    }

    echo json_encode($response);
    exit;
}
