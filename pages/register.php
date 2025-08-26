<?php
session_start();
header("Access-Control-Allow-Origin: *");
if(isset($_SESSION['user_id'])){
    Header('Location:browse.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JourneyMate</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="register-container">
    <h2>Create Account</h2>
    <div id="message"></div>
    <form id="registerForm" novalidate>
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required />
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>

<script>
    const form = document.getElementById('registerForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        messageDiv.innerHTML = '';
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Frontend basic validation
        if (!data.firstname || !data.lastname || !data.email || !data.password || !data.password_confirm) {
            messageDiv.innerHTML = '<div class="alert alert-warning">Please fill in all fields.</div>';
            return;
        }
        if (data.password !== data.password_confirm) {
            messageDiv.innerHTML = '<div class="alert alert-warning">Passwords do not match.</div>';
            return;
        }

        try {
            const response = await fetch('../api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                form.reset();
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1000);
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
            }
        } catch (error) {
            messageDiv.innerHTML = `<div class="alert alert-danger">Error connecting to server.</div>`;
        }


    });
</script>
</body>
</html>
