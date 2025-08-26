<!DOCTYPE html>
<html>
<head>
    <title>Unos proizvoda</title>
</head>
<body>
<h2>Unesi naziv proizvoda</h2>
<input type="text" id="title" placeholder="Naziv proizvoda" required>
<button onclick="unesi()">Unesi</button>

<p id="response"></p>

<script>
    function unesi() {
        const title = document.getElementById('title').value;

        fetch('../api/products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ title })
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerText = data.message;
            })
            .catch(error => {
                document.getElementById('response').innerText = 'Greška: ' + error;
            });
    }
</script>
</body>
</html>
