<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $hint = $_POST['password_hint'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND fullname = ? AND password_hint = ?");
    $stmt->execute([$username, $fullname, $hint]);
    $user = $stmt->fetch();

    if ($user) {
        // Redirect to reset password page
        $_SESSION['reset_user_id'] = $user['id'];
        header('Location: reset_password.php');
    } else {
        echo "<script>alert('Incorrect information! Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/bg-img.jpg'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .glass-effect {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="glass-effect p-5 rounded shadow-lg text-center" style="max-width: 400px; width: 100%;">
        <h2 class="mb-4 text-dark">Forgot Password</h2>
        <form method="POST" action="forgot_password.php">
            <div class="mb-3">
                <input type="text" name="username" placeholder="Username" required class="form-control">
            </div>
            <div class="mb-3">
                <input type="text" name="fullname" placeholder="Full Name" required class="form-control">
            </div>
            <div class="mb-3">
                <input type="text" name="password_hint" placeholder="Password Hint" required class="form-control">
            </div>
            <button type="submit" class="btn btn-green w-100">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
