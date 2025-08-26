<?php session_start(); ?>
<?php
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] === 'user') {
    Header("Location:browse.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Attraction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <div class="card shadow rounded-4 p-4">
        <h2 class="mb-4"><i class="bi bi-plus-circle"></i> Add New Attraction</h2>

        <form id="addAttractionForm" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Attraction Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="E.g. Eiffel Tower" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the attraction..." required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" name="country_id" required>
                        <option value="">Select Country</option>
                        <!-- JS will populate -->
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="city" class="form-label">City</label>
                    <select class="form-select" id="city" name="city_id" required>
                        <option value="">Select City</option>
                        <!-- JS will populate -->
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="E.g. Washington Street 410" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="budget" class="form-label">Budget</label>
                    <select class="form-select" id="budget" name="budget">
                        <option value="">Select Budget</option>
                        <option value="$">$ - Budget</option>
                        <option value="$$">$$ - Moderate</option>
                        <option value="$$$">$$$ - Premium</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Attraction Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save"></i> Save Attraction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const countrySelect = document.getElementById('country');
        const citySelect = document.getElementById('city');

        // Load countries
        fetch('../api/getCountries.php')
            .then(res => res.json())
            .then(countries => {
                countries.forEach(country => {
                    const opt = document.createElement('option');
                    opt.value = country.country_id;
                    opt.textContent = country.country_name;
                    countrySelect.appendChild(opt);
                });
            });

        // Load cities when country is selected
        countrySelect.addEventListener('change', () => {
            const countryId = countrySelect.value;
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (!countryId) return;

            fetch(`../api/getCities.php?country_id=${countryId}`)
                .then(res => res.json())
                .then(cities => {
                    cities.forEach(city => {
                        const opt = document.createElement('option');
                        opt.value = city.city_id;
                        opt.textContent = city.city;
                        citySelect.appendChild(opt);
                    });
                });
        });
        // AJAX submit with redirect only
        const form = document.getElementById('addAttractionForm');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await fetch('../api/addAttraction.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = 'browse.php';
                }
                else{
                    window.location.href = 'index.php';
                }
            } catch (error) {
                // Optionally handle error silently or log it
                console.error('Server error:', error);
            }
        });

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
