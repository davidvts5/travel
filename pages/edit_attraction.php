<?php
session_start();
require_once '../config/db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'agency') {
    header("Location: browse.php");
    exit;
}

$agencyId = $_SESSION['user_id'];
$attractionId = $_GET['id'] ?? null;

if (!$attractionId) {
    header("Location: my_attractions.php");
    exit;
}

// Dohvati podatke atrakcije samo za prikaz
$pdo = connectDb();
$stmt = $pdo->prepare("
    SELECT a.*, c.city, co.country_name
    FROM attractions a
    JOIN cities c ON a.city_id = c.city_id
    JOIN countries co ON c.country_id = co.country_id
    WHERE a.attraction_id = :id AND a.user_id = :agency_id
");
$stmt->execute([
    'id' => $attractionId,
    'agency_id' => $agencyId
]);
$attraction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$attraction) {
    die("Attraction not found or you don't have permission to edit it.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Attraction</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Attraction</h2>
    <form id="editAttractionForm" enctype="multipart/form-data">
        <input type="hidden" id="attraction_id" name="attraction_id" value="<?= $attractionId ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($attraction['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description*</label>
            <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($attraction['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address*</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($attraction['address']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="budget" class="form-label">Budget</label>
            <select class="form-select" id="budget" name="budget">
                <option value="$" <?= $attraction['budget']==='$' ? 'selected':'' ?>>$</option>
                <option value="$$" <?= $attraction['budget']==='$$' ? 'selected':'' ?>>$$</option>
                <option value="$$$" <?= $attraction['budget']==='$$$' ? 'selected':'' ?>>$$$</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Attraction Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <?php if(!empty($attraction['image_url'])): ?>
                <img src="../<?= htmlspecialchars($attraction['image_url']) ?>" alt="Current Image" class="mt-2" style="max-width:200px;">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($attraction['city']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Country</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($attraction['country_name']) ?>" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="my_attractions.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#editAttractionForm').on('submit', function(e){
            e.preventDefault();

            const formData = new FormData(this); // uzima sve inpute + file

            $.ajax({
                url: '../api/editAttraction.php', // tvoj API
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res.success){
                        alert(res.message);
                        window.location.href = 'my_attractions.php';
                    } else {
                        alert('Error: ' + res.error);
                    }
                },
                error: function(xhr){
                    alert('AJAX error: ' + xhr.responseText);
                }
            });
        });
    });
</script>
</body>
</html>
