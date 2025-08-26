<?php
session_start();
require_once '../config/db_config.php';
$pdo = connectDb();
if (!isset($_GET['id'])) {
    header("Location: browse.php");
    exit;
}
$attraction_id = (int) $_GET['id'];

$sql = "SELECT a.*, ci.city, co.country_name
        FROM attractions a
        JOIN cities ci ON a.city_id = ci.city_id
        JOIN countries co ON ci.country_id = co.country_id
        WHERE a.attraction_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $attraction_id]);
$attraction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$attraction) {
    echo "Attraction not found.";
    exit;
}

$commentsSql = "SELECT c.comment, c.rating, c.created_at, u.firstname, u.lastname
                FROM comments c
                JOIN users u ON c.user_id = u.user_id
                WHERE c.attraction_id = :id
                ORDER BY c.created_at DESC";
$commentsStmt = $pdo->prepare($commentsSql);
$commentsStmt->execute(['id' => $attraction_id]);
$comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($attraction['name']) ?> | JourneyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">

    <div class="card shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-start">
                <div class="col-md-8">
                    <h2 class="card-title"><?= htmlspecialchars($attraction['name']) ?></h2>
                    <p class="text-muted">
                        <i class="bi bi-geo-alt-fill"></i>
                        <?= htmlspecialchars($attraction['city']) ?>, <?= htmlspecialchars($attraction['country_name']) ?>
                    </p>
                    <p class="fw-semibold">
                        <i class="bi bi-currency-dollar"></i>
                        Budget: <?= htmlspecialchars($attraction['budget'] ?? 'N/A') ?>
                    </p>
                    <p class="fw-semibold">
                        <i class="bi bi-house-door"></i>
                        Address: <?= htmlspecialchars($attraction['address']) ?>
                    </p>
                    <hr>
                    <p class="card-text"><?= nl2br(htmlspecialchars($attraction['description'])) ?></p>
                </div>

                <div class="col-md-4">
                    <?php if (!empty($attraction['image_url'])): ?>
                        <img src="../images/<?= htmlspecialchars($attraction['image_url']) ?>"
                             alt="<?= htmlspecialchars($attraction['name']) ?>"
                             class="img-fluid rounded attraction-image"
                             style="object-fit: cover; width: 100%; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="card shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <h4><i class="bi bi-cloud-sun"></i> Weather Forecast</h4>
                <div class="p-2 row justify-content-center" id="weather-forecast">
                    <p>Loading weather data...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5" id="comments">
        <h4><i class="bi bi-chat-left-dots"></i> Comments</h4>

        <?php if (!empty($comments)): ?>
            <ul class="list-group mb-3">
                <?php foreach ($comments as $c): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($c['firstname'] . ' ' . $c['lastname']) ?></strong>
                        <span class="text-warning fs-4">
                            <?= str_repeat('★', (int)$c['rating']) ?><?= str_repeat('☆', 5 - (int)$c['rating']) ?>
                        </span>
                        <br>
                        <?= nl2br(htmlspecialchars($c['comment'])) ?>
                        <br>
                        <small class="text-muted"><?= date('d M Y H:i', strtotime($c['created_at'])) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const apiKey = "db5ed40d0becbbb4399b8d64821cb03e";
        const city = "<?= urlencode($attraction['city']) ?>";
        const country = "<?= urlencode($attraction['country_name']) ?>";

        try {
            let geoRes = await fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${city},${country}&limit=1&appid=${apiKey}`);
            let geoData = await geoRes.json();
            if (!geoData || geoData.length === 0) {
                document.getElementById("weather-forecast").innerHTML = "<p>Weather data unavailable.</p>";
                return;
            }
            const { lat, lon } = geoData[0];
            let weatherRes = await fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`);
            let weatherData = await weatherRes.json();

            const forecastEl = document.getElementById("weather-forecast");
            forecastEl.innerHTML = "";

            let daily = {};
            weatherData.list.forEach(entry => {
                const date = new Date(entry.dt * 1000);
                const dayKey = date.toLocaleDateString("en-GB");
                const hour = date.getHours();
                const targetHour = 14;
                if (!daily[dayKey]) daily[dayKey] = entry;
                else {
                    const currentDiff = Math.abs(new Date(daily[dayKey].dt * 1000).getHours() - targetHour);
                    const newDiff = Math.abs(hour - targetHour);
                    if (newDiff < currentDiff) daily[dayKey] = entry;
                }
            });

            forecastEl.classList.add("d-flex", "justify-content-center", "flex-wrap", "gap-3");
            Object.values(daily).slice(0,5).forEach((day, i) => {
                const date = new Date(day.dt * 1000);
                const icon = day.weather[0].icon;
                const temp = Math.round(day.main.temp);
                const formattedDate = date.toLocaleDateString("en-GB", { weekday: "short", day: "2-digit", month: "2-digit", year: "numeric" });

                forecastEl.innerHTML += `
                    <div class="col-md-2">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <h6>${i === 0 ? "Today" : formattedDate}</h6>
                                <img src="https://openweathermap.org/img/wn/${icon}@2x.png">
                                <p class="mb-0"><strong>${temp}°C</strong></p>
                            </div>
                        </div>
                    </div>
                `;
            });

        } catch (err) {
            console.error(err);
            document.getElementById("weather-forecast").innerHTML = "<p>Error loading weather.</p>";
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
