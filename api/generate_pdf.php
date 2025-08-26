<?php
require_once '../vendor/autoload.php';
require_once '../config/db_config.php';
$conn = connectDb();

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_POST['tour_id']) || !is_numeric($_POST['tour_id'])) {
    http_response_code(400);
    echo "Invalid tour ID";
    exit;
}

$tourId = $_POST['tour_id'];

$stmt = $conn->prepare("SELECT tour_name FROM tours WHERE tour_id = ?");
$stmt->execute([$tourId]);
$tour = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tour) {
    http_response_code(404);
    echo "Tour not found";
    exit;
}

$query = "
    SELECT 
        a.name, a.description, a.address, a.budget, a.image_url,
        ci.city AS city_name,
        co.country_name
    FROM tour_attractions ta
    JOIN attractions a ON ta.attraction_id = a.attraction_id
    JOIN cities ci ON a.city_id = ci.city_id
    JOIN countries co ON ci.country_id = co.country_id
    WHERE ta.tour_id = ?
";
$stmt = $conn->prepare($query);
$stmt->execute([$tourId]);
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = "<h1>" . htmlspecialchars($tour['tour_name']) . "</h1><hr>";
$html .= "<h2>Attractions:</h2><ul>";

foreach ($attractions as $attr) {
    $html .= "<li><strong>" . htmlspecialchars($attr['name']) . "</strong> (" .
        htmlspecialchars($attr['city_name']) . ", " .
        htmlspecialchars($attr['country_name']) . ")<br>" .
        "<em>" . nl2br(htmlspecialchars($attr['description'])) . "</em><br>" .
        "<strong>Adresa:</strong> " . htmlspecialchars($attr['address']) . "<br>" .
        "<strong>Budžet:</strong> " . htmlspecialchars($attr['budget']) .
        "</li><br>";
}
$html .= "</ul>";

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Generisanje i slanje PDF-a
$filename = "tour_{$tourId}.pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
