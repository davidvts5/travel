<?php
session_start();
require_once '../config/db_config.php';
$pdo = connectDb();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['tour_id']) || !is_numeric($_GET['tour_id'])) {
    echo "Invalid tour ID.";
    exit;
}

$tourId = $_GET['tour_id'];
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT tour_name FROM tours WHERE tour_id = ? AND user_id = ?");
$stmt->execute([$tourId, $userId]);
$tour = $stmt->fetch();

if (!$tour) {
    echo "Tour not found or does not belong to this user.";
    exit;
}

$query = "
    SELECT 
        a.attraction_id, a.name, a.description, a.address, a.budget, a.image_url,
        ci.city AS city_name,
        co.country_name
    FROM tour_attractions ta
    JOIN attractions a ON ta.attraction_id = a.attraction_id
    JOIN cities ci ON a.city_id = ci.city_id
    JOIN countries co ON ci.country_id = co.country_id
    WHERE ta.tour_id = ?
";
$stmt = $pdo->prepare($query);
$stmt->execute([$tourId]);
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tour Details | JourneyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-map"></i> Tour: <?= htmlspecialchars($tour['tour_name']) ?></h2>
        <a href="my_tours.php" class="btn btn-secondary">
            <i class="m-1 bi bi-arrow-left"></i> Back to My Tours
        </a>
        <form method="POST" action="../api/generate_pdf.php" target="_blank">
            <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tourId) ?>">
            <button type="submit" class="btn btn-primary m-1">Download as PDF</button>
        </form>

    </div>

    <?php if (empty($attractions)): ?>
        <div class="alert alert-warning text-center">This tour has no attractions yet.</div>
    <?php else: ?>
        <div class="d-flex flex-column align-items-center">
            <?php foreach ($attractions as $index => $a): ?>
                <div class="list-group-item mb-4 border rounded shadow-sm p-3 w-100 cardcolor shadow" style="max-width: 800px;">
                    <div class="row g-3 align-items-start">
                        <div class="col-md-4">
                            <img src="<?= htmlspecialchars($a['image_url'] ?: 'https://via.placeholder.com/400x200?text=No+Image') ?>"
                                 alt="<?= htmlspecialchars($a['name']) ?>"
                                 class="img-fluid rounded attraction-img">
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-2">
                                <?= ($index + 1) . '. ' . htmlspecialchars($a['name']) ?>
                            </h5>
                            <p class="mb-2 text-muted">
                                <i class="bi bi-geo-alt-fill"></i>
                                <?= htmlspecialchars($a['city_name']) ?>, <?= htmlspecialchars($a['country_name']) ?>
                            </p>
                            <ul class="list-unstyled mb-2 small">
                                <li><strong>Budget:</strong> <?= htmlspecialchars($a['budget']) ?></li>
                                <li><strong>Address:</strong> <?= htmlspecialchars($a['address']) ?></li>
                            </ul>
                            <p class="text-muted"><?= nl2br(htmlspecialchars($a['description'])) ?></p>

                            <!-- Dugme za uklanjanje -->
                            <form method="POST" action="../api/RemoveFromTour.php" class="mt-2">
                                <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tourId) ?>">
                                <input type="hidden" name="attraction_id" value="<?= htmlspecialchars($a['attraction_id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Remove from Tour
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
