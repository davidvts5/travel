<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: browse.php");
    exit;
}
require_once '../config/db_config.php'; // konekcija na bazu
$pdo = connectDb();

// Fetch countries and cities
$countries = $pdo->query("SELECT * FROM countries ORDER BY country_name")->fetchAll(PDO::FETCH_ASSOC);
$cities = $pdo->query("
    SELECT ci.city_id, ci.city, co.country_name, co.country_id 
    FROM cities ci
    JOIN countries co ON ci.country_id = co.country_id
    ORDER BY ci.city
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Cities & Countries | JourneyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">

    <!-- Countries Management -->
    <div class="card shadow-lg rounded-4 mb-5">
        <div class="card-body">
            <h3>Countries</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                <i class="bi bi-plus-lg"></i> Add New Country
            </button>
            <table id="countriesTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Country Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($countries as $country): ?>
                    <tr>
                        <td><?= $country['country_id'] ?></td>
                        <td><?= htmlspecialchars($country['country_name']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditCountryModal(<?= $country['country_id'] ?>, '<?= htmlspecialchars($country['country_name'], ENT_QUOTES) ?>')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                    class="btn btn-danger btn-sm"
                                    onclick="deleteCountry(<?= $country['country_id'] ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cities Management -->
    <div class="card shadow-lg rounded-4 mb-5">
        <div class="card-body">
            <h3>Cities</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCityModal">
                <i class="bi bi-plus-lg"></i> Add New City
            </button>
            <table id="citiesTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cities as $city): ?>
                    <tr>
                        <td><?= $city['city_id'] ?></td>
                        <td><?= htmlspecialchars($city['city']) ?></td>
                        <td><?= htmlspecialchars($city['country_name']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditCityModal(<?= $city['city_id'] ?>, '<?= htmlspecialchars($city['city'], ENT_QUOTES) ?>', <?= $city['country_id'] ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                    class="btn btn-danger btn-sm"
                                    onclick="deleteCity(<?= $city['city_id'] ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Add Country Modal -->
<div class="modal fade" id="addCountryModal" tabindex="-1" aria-labelledby="addCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="admin_cities_countries_crud.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCountryModalLabel">Add New Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_country">
                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country Name</label>
                        <input type="text" name="country_name" id="country_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="admin_cities_countries_crud.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityModalLabel">Add New City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_city">
                    <div class="mb-3">
                        <label for="city_name" class="form-label">City Name</label>
                        <input type="text" name="city_name" id="city_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="city_country" class="form-label">Country</label>
                        <select name="city_country" id="city_country" class="form-select" required>
                            <?php foreach($countries as $country): ?>
                                <option value="<?= $country['country_id'] ?>"><?= htmlspecialchars($country['country_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Country Modal -->
<div class="modal fade" id="editCountryModal" tabindex="-1" aria-labelledby="editCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCountryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCountryModalLabel">Edit Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_country">
                    <input type="hidden" name="id" id="edit_country_id">
                    <div class="mb-3">
                        <label for="edit_country_name" class="form-label">Country Name</label>
                        <input type="text" name="country_name" id="edit_country_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editCityModal" tabindex="-1" aria-labelledby="editCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCityForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCityModalLabel">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_city">
                    <input type="hidden" name="id" id="edit_city_id">

                    <div class="mb-3">
                        <label for="edit_city_name" class="form-label">City Name</label>
                        <input type="text" name="city_name" id="edit_city_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_city_country" class="form-label">Country</label>
                        <select name="city_country" id="edit_city_country" class="form-select" required>
                            <?php foreach($countries as $country): ?>
                                <option value="<?= $country['country_id'] ?>">
                                    <?= htmlspecialchars($country['country_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function deleteCountry(id) {
        if (!confirm("Are you sure?")) return;

        const formData = new FormData();
        formData.append("action", "delete_country");
        formData.append("id", id);

        fetch("../api/admin_cities_countries_crud.php", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // ili bolje ukloni red iz tabele preko JS
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => console.error(err));
    }
    function deleteCity(id) {
        if (!confirm("Are you sure?")) return;

        const formData = new FormData();
        formData.append("action", "delete_city");
        formData.append("id", id);

        fetch("../api/admin_cities_countries_crud.php", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => console.error(err));
    }

    // Dodavanje države
    document.querySelector('#addCountryModal form').addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(this);

        fetch('../api/admin_cities_countries_crud.php', { method:'POST', body:formData })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    alert(data.message);

                    // 1️⃣ Dodaj u dropdown gradova
                    const select = document.querySelector('#city_country');
                    const option = document.createElement('option');
                    option.value = data.new_id;
                    option.textContent = formData.get('country_name');
                    select.appendChild(option);

                    // 2️⃣ Dodaj u tabelu država
                    const tableBody = document.querySelector('#countriesTable tbody');
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${data.new_id}</td>
                    <td>${formData.get('country_name')}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCountry(${data.new_id})"><i class="bi bi-trash"></i></button>
                    </td>
                `;
                    tableBody.appendChild(tr);

                    bootstrap.Modal.getInstance(document.getElementById('addCountryModal')).hide();
                    this.reset();
                } else alert(data.message);
            })
            .catch(err => console.error(err));
    });

    // Dodavanje grada
    document.querySelector('#addCityModal form').addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(this);

        fetch('../api/admin_cities_countries_crud.php', { method:'POST', body:formData })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    alert(data.message);

                    // Dodaj red u tabelu gradova
                    const tableBody = document.querySelector('#citiesTable tbody');
                    const countryName = document.querySelector('#city_country option:checked').textContent;
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${data.new_id}</td>
                    <td>${formData.get('city_name')}</td>
                    <td>${countryName}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCity(${data.new_id})"><i class="bi bi-trash"></i></button>
                    </td>
                `;
                    tableBody.appendChild(tr);

                    bootstrap.Modal.getInstance(document.getElementById('addCityModal')).hide();
                    this.reset();
                } else alert(data.message);
            })
            .catch(err => console.error(err));
    });
    function openEditCountryModal(id, name) {
        document.getElementById('edit_country_id').value = id;
        document.getElementById('edit_country_name').value = name;

        const editModal = new bootstrap.Modal(document.getElementById('editCountryModal'));
        editModal.show();
    }

    // submit forme
    document.getElementById('editCountryForm').addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(this);

        fetch('../api/admin_cities_countries_crud.php', { method:'POST', body:formData })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    alert(data.message);

                    // Ažuriraj ime u tabeli
                    const row = document.querySelector(`#countriesTable tbody tr td:first-child:contains('${formData.get('id')}')`).parentElement;
                    row.children[1].textContent = formData.get('country_name');

                    bootstrap.Modal.getInstance(document.getElementById('editCountryModal')).hide();
                } else alert(data.message);
            })
            .catch(err => console.error(err));
    });

    // Otvori modal i popuni ga podacima
    function openEditCityModal(id, name, countryId) {
        document.getElementById('edit_city_id').value = id;
        document.getElementById('edit_city_name').value = name;
        document.getElementById('edit_city_country').value = countryId;

        const modal = new bootstrap.Modal(document.getElementById('editCityModal'));
        modal.show();
    }

    // Submit forme (fetch)
    document.getElementById('editCityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('../api/admin_cities_countries_crud.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // ili update reda u tabeli preko JS
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => console.error(err));
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
