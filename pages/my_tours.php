<?php
session_start();
require_once '../config/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$pdo = connectDb();
$user_id = $_SESSION['user_id'];

// Fetch all tours for the current user
$stmt = $pdo->prepare("SELECT * FROM tours WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Tours | JourneyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-globe"></i> My Tours</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTourModal">
            <i class="bi bi-plus-circle"></i> Create New Tour
        </button>
    </div>

    <?php if (count($tours) > 0): ?>
        <div class="row">
            <?php foreach ($tours as $tour): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border border-1">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($tour['tour_name']) ?></h5>
                            <p class="text-muted">Created: <?= date('F j, Y', strtotime($tour['created_at'])) ?></p>
                            <a href="tour_details.php?tour_id=<?= $tour['tour_id'] ?>" class="btn btn-primary mt-auto">
                                <i class="bi bi-eye"></i> View Tour
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">You haven't created any tours yet.</p>
    <?php endif; ?>
</div>
<?php if (isset($_SESSION['tour_error'])): ?>
    <div id="tour-error-msg" class="alert alert-danger text-center m-5">
        <?= htmlspecialchars($_SESSION['tour_error']) ?>
    </div>
    <?php unset($_SESSION['tour_error']); ?>
<?php endif; ?>

<!-- MODAL: Create New Tour -->
<div class="modal fade" id="createTourModal" tabindex="-1" aria-labelledby="createTourModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createTourForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTourModalLabel">Create New Tour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tourName" class="form-label">Tour Name</label>
                        <input type="text" class="form-control" id="tourName" name="tour_name" required>
                    </div>
                    <div id="tourMessage" class="mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createTourForm = document.getElementById('createTourForm');
        const tourMessage = document.getElementById('tourMessage');
        const createTourModal = new bootstrap.Modal(document.getElementById('createTourModal'));
        const toursContainer = document.querySelector('.row'); // container gde su tura kartice

        createTourForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const tourName = document.getElementById('tourName').value.trim();
            if (!tourName) {
                tourMessage.innerHTML = `<div class="alert alert-warning">Please enter a tour name.</div>`;
                return;
            }

            const formData = new FormData();
            formData.append('tour_name', tourName);

            try {
                const response = await fetch('../api/createTour.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    tourMessage.innerHTML = `<div class="alert alert-success">${result.message}</div>`;

                    // Dodavanje nove ture u UI odmah (bez refresh)
                    if (toursContainer) {
                        const div = document.createElement('div');
                        div.className = 'col-md-4 mb-4';
                        div.innerHTML = `
                        <div class="card shadow-sm h-100 border border-1">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${tourName}</h5>
                                <p class="text-muted">Created: ${new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</p>
                                <a href="tour_details.php?tour_id=${result.tour_id}" class="btn btn-primary mt-auto">
                                    <i class="bi bi-eye"></i> View Tour
                                </a>
                            </div>
                        </div>`;
                        toursContainer.prepend(div);
                    }

                    // Reset i zatvori modal
                    createTourForm.reset();
                    setTimeout(() => createTourModal.hide(), 500);
                } else {
                    tourMessage.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
                }
            } catch (err) {
                console.error(err);
                tourMessage.innerHTML = `<div class="alert alert-danger">Server error.</div>`;
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const errorMsg = document.getElementById('tour-error-msg');
        if (errorMsg) {
            setTimeout(() => {
                errorMsg.style.transition = 'opacity 0.5s ease';
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 500);
            },1000);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
