<?php
include 'config.php';
session_start();

if (!isset($_SESSION['reset_user_id'])) {
    // Redirect if the user has not been validated for a password reset
    header('Location: forgot_password.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Hash the new password for security
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $_SESSION['reset_user_id']]);

        // Clear session data related to password reset
        unset($_SESSION['reset_user_id']);
        
        echo "<script>alert('Password reset successfully. Please log in with your new password.');</script>";
        header('Location: login.php');
    } else {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Added Font Awesome -->
    <style>
        body {
            background-image: url('img/bg-img.jpg');
            background-size: cover;
            background-position: center;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .btn-green {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .btn-green:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .link-green {
            color: #28a745;
            text-decoration: none;
        }
        .link-green:hover {
            color: #218838;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #808080; /* Gray color for icon */
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="form-container text-center">
        <h2 class="mb-4 text-dark">Reset Password</h2>
        <form method="POST" action="reset_password.php">
            <div class="mb-3 password-container">
                <input type="password" name="new_password" id="new_password" placeholder="New Password" required class="form-control">
                <i class="fas fa-eye toggle-password" id="toggleNewPassword" onclick="togglePassword('new_password', 'toggleNewPassword')"></i>
            </div>
            <div class="mb-3 password-container">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required class="form-control">
                <i class="fas fa-eye toggle-password" id="toggleConfirmPassword" onclick="togglePassword('confirm_password', 'toggleConfirmPassword')"></i>
            </div>
            <button type="submit" class="btn btn-green w-100">Reset Password</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId, toggleId) {
            const field = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(toggleId);
            if (field.type === 'password') {
                field.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash'); // Change to eye-slash when visible
            } else {
                field.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye'); // Change back to eye when hidden
            }
        }
    </script>
</body>
</html>
