document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('filterCountry');
    const citySelect = document.getElementById('filterCity');
    const tourModal = document.getElementById('addToTourModal');
    const tourSelect = document.getElementById('tourSelect');
    const newTourInput = document.getElementById('newTourInput');
    const addToTourForm = document.getElementById('addToTourForm');
    const selectedAttractionInput = document.getElementById('selectedAttractionId');

    // ? Logovanje ure?aja odmah pri load-u
    fetch('../api/log_device.php')
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                console.warn('Device log not saved');
            }
        })
        .catch(err => console.error('Error logging device:', err));

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    function fetchAttractions(filters) {
        const params = new URLSearchParams(filters).toString();
        fetch(`../api/getFilteredAttractions.php?${params}`)
            .then(res => res.json())
            .then(result => {
                const container = document.getElementById('attractions-container');
                const noData = document.getElementById('no-attractions');
                container.innerHTML = '';

                if (result.success && result.data.length > 0) {
                    result.data.forEach(attr => {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';

                        col.innerHTML = `
                            <div class="card h-100 p-3 shadow-sm cardcolor">
                                ${attr.image_url ? `<img src="${escapeHtml(attr.image_url)}" class="rounded-1 card-img-top attraction-image" alt="${escapeHtml(attr.name)}">` : ''}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">${escapeHtml(attr.name)}</h5>
                                    <p class="card-text flex-grow-1">${escapeHtml(attr.country + ', ' + attr.city)}</p>
                                    <a href="attraction_details.php?id=${encodeURIComponent(attr.attraction_id)}" class="btn btn-primary mt-auto">View Details</a>
                                    ${isLoggedIn ? `
                                    <button class="mt-1 btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addToTourModal" data-id="${attr.attraction_id}">
                                        <i class="bi bi-plus-circle"></i> Add to Tour
                                    </button>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                        container.appendChild(col);
                    });
                    noData.style.display = 'none';
                } else {
                    noData.style.display = 'block';
                    noData.textContent = 'No attractions found.';
                }
            })
            .catch(err => {
                console.error('Greška pri dohvatanju atrakcija:', err);
                const noData = document.getElementById('no-attractions');
                noData.style.display = 'block';
                noData.textContent = 'Error loading attractions.';
            });
    }

    // ? U?itavanje država
    fetch('../api/getCountries.php')
        .then(res => res.json())
        .then(countries => {
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.country_id;
                option.textContent = country.country_name;
                countrySelect.appendChild(option);
            });
        })
        .catch(err => console.error('Greška pri u?itavanju država:', err));

    // ? Promena države ? u?itaj gradove
    countrySelect.addEventListener('change', function () {
        const countryId = this.value;
        citySelect.innerHTML = '<option value="">All Cities</option>';
        if (!countryId) return;

        fetch(`../api/getCities.php?country_id=${countryId}`)
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.city_id;
                    option.textContent = city.city;
                    citySelect.appendChild(option);
                });
            })
            .catch(err => console.error('Greška pri u?itavanju gradova:', err));
    });

    // ? Filteri
    document.getElementById('applyFilters').addEventListener('click', () => {
        const filters = {
            name: document.getElementById('searchName').value,
            country: countrySelect.value,
            city: citySelect.value,
            rating: document.getElementById('filterRating').value,
            budget: document.getElementById('filterBudget').value
        };
        fetchAttractions(filters);
    });

    document.getElementById('resetFilters').addEventListener('click', () => {
        document.getElementById('searchName').value = '';
        countrySelect.value = '';
        citySelect.innerHTML = '<option value="">All Cities</option>';
        document.getElementById('filterRating').value = '';
        document.getElementById('filterBudget').value = '';
        fetchAttractions({});
    });

    // ? Otvaranje modala i u?itavanje tura
    tourModal.addEventListener('show.bs.modal', async (event) => {
        const button = event.relatedTarget;
        const attractionId = button.getAttribute('data-id');
        selectedAttractionInput.value = attractionId;

        tourSelect.innerHTML = '<option value="">Choose a tour</option>';
        newTourInput.style.display = 'none';
        document.getElementById('newTourName').value = '';

        try {
            const response = await fetch('../api/getUserTours.php');
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                result.data.forEach(tour => {
                    const option = document.createElement('option');
                    option.value = tour.tour_id;
                    option.textContent = tour.tour_name;
                    tourSelect.appendChild(option);
                });
            }

            const createOption = document.createElement('option');
            createOption.value = '__new__';
            createOption.textContent = '+ Create new tour';
            tourSelect.appendChild(createOption);
        } catch (err) {
            console.error('Error loading tours:', err);
        }
    });

    // ? Ako izabereš "Create new tour"
    tourSelect.addEventListener('change', () => {
        newTourInput.style.display = tourSelect.value === '__new__' ? 'block' : 'none';
    });

    // ? Dodavanje u turu
    addToTourForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(addToTourForm);

        if (tourSelect.value === '__new__') {
            const newTourName = document.getElementById('newTourName').value.trim();
            if (!newTourName) {
                alert('Please enter a name for the new tour.');
                return;
            }
            formData.append('create_new', '1');
        }

        try {
            const response = await fetch('../api/addToTour.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showNotification(result.message || 'Added to tour!');
                bootstrap.Modal.getInstance(tourModal).hide();
            } else {
                showNotification(result.message || 'Error occurred.');
            }
        } catch (err) {
            console.error('Error adding to tour:', err);
            showNotification('Server error');
        }
    });

    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `alert alert-${type} show`;
        notification.classList.remove('d-none');

        setTimeout(() => {
            notification.classList.add('d-none');
        }, 2000);
    }

    // ? inicijalno u?itavanje atrakcija
    fetchAttractions({});
});
