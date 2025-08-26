<?php
session_start();
if(isset($_SESSION['user_id'])){
    Header('Location:browse.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - JourneyMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="register-container">
    <h2>Login</h2>
    <div id="message"></div>
    <form id="loginForm" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div>
        <div class="text-center mt-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot password?</a>
            <hr>
            <a href="register.php">Sign up</a>
        </div>


    </div>


</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="resetMessage"></div>
                <form id="resetForm" novalidate>
                    <div class="mb-3">
                        <label for="resetEmail" class="form-label">Enter your email address</label>
                        <input type="email" class="form-control" id="resetEmail" name="resetEmail" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Send reset link</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const form = document.getElementById('loginForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        messageDiv.innerHTML = '';
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        if (!data.email || !data.password) {
            messageDiv.innerHTML = '<div class="alert alert-warning">Please fill in all fields.</div>';
            return;
        }

        try {
            const response = await fetch('../api/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                setTimeout(() => { window.location.href = 'index.php'; }, 333);
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
            }
        } catch (error) {
            messageDiv.innerHTML = `<div class="alert alert-danger">Error connecting to server.</div>`;
        }
    });

    // Reset password form
    const resetForm = document.getElementById('resetForm');
    const resetMessage = document.getElementById('resetMessage');

    resetForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        resetMessage.innerHTML = '';

        const formData = new FormData(resetForm);
        const data = Object.fromEntries(formData.entries());

        if (!data.resetEmail) {
            resetMessage.innerHTML = '<div class="alert alert-warning">Please enter your email.</div>';
            return;
        }

        try {
            const response = await fetch('../api/requestPasswordReset.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: data.resetEmail }),
            });

            const result = await response.text(); // može biti plain text iz API-ja
            resetMessage.innerHTML = `<div class="alert alert-info">${result}</div>`;
        } catch (error) {
            resetMessage.innerHTML = `<div class="alert alert-danger">Error sending reset link.</div>`;
        }
    });
</script>

</body>
</html>
