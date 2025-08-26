<?php
// api/attractions.php
/**
 * @OA\Get(
 *     path="/api/attractions",
 *     summary="Get all locations",
 *     @OA\Response(response=200, description="Success")
 * )
 */
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db_config.php';

$pdo = connectDb();

try {
    $stmt = $pdo->query("SELECT a.attraction_id, a.name, a.description, a.image_url, c.city, c.country FROM attractions a JOIN cities c ON a.city_id = c.city_id;");
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $attractions
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}

