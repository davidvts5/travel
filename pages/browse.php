<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JourneyMate - Attractions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script>
        const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
    </script>

    <script src="../pages-js/browse.js" defer></script>
</head>
<body>

<?php include '../components/navbar.php'; ?>

<div class="modal fade" id="addToTourModal" tabindex="-1" aria-labelledby="addToTourModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addToTourForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToTourModalLabel">Add Attraction to Tour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="selectedAttractionId" name="attraction_id">
                    <span class="p-3" style="z-index: 9999;">
                        <span id="notification" class="alert d-none" role="alert"></span>
                    </span>
                    <div class="mb-3">
                        <label for="tourSelect" class="form-label">Select Tour</label>
                        <select class="form-select" id="tourSelect" name="tour_id" required>
                            <option value="">Choose a tour</option>
                            <option value="__new__">+ Create new tour</option>
                        </select>
                    </div>

                    <div class="mb-3" id="newTourInput" style="display: none;">
                        <label for="newTourName" class="form-label">New Tour Name</label>
                        <input type="text" class="form-control" id="newTourName" name="new_tour_name" placeholder="Enter name for new tour">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- FILTER SEKCIJA -->
<div class="container mt-4">
    <div class="card shadow-sm rounded-4 p-4 mb-4 border border-2 border-light-subtle">
        <h4 class="mb-3">Filter Attractions</h4>
        <div class="row g-3 align-items-end">
            <div class="col-md-2">
                <input type="text" id="searchName" class="form-control" placeholder="Search by name">
            </div>
            <div class="col-md-2">
                <select id="filterCountry" class="form-select">
                    <option value="">All Countries</option>
                    <!-- Države se pune dinamički -->
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterCity" class="form-select">
                    <option value="">All Cities</option>
                    <!-- Gradovi se pune dinamički -->
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterRating" class="form-select">
                    <option value="">Rating</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterBudget" class="form-select">
                    <option value="">Budget</option>
                    <option value="$">$</option>
                    <option value="$$">$$</option>
                    <option value="$$$">$$$</option>
                </select>
            </div>
            <div class="col-md-1">
                <button id="applyFilters" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-1 text-end">
                <button id="resetFilters" class="btn btn-outline-secondary w-100">Reset</button>
            </div>
        </div>
    </div>
</div>
<!-- ATRAKCIJE -->
<div class="container">
    <div class="row">
        <h2 class="mb-4">Explore Attractions</h2>
        <div id="attractions-container" class="row"></div>
        <p id="no-attractions" class="text-danger" style="display:none;">No attractions found.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
