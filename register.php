<?php
include 'config.php';

$error = "";
$inputErrors = []; // Array untuk menyimpan error per input field


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ktp = $_POST['ktp'];
    $phone = $_POST['phone'];
    $fullname = $_POST['fullname'];
    $birth_place = $_POST['birth_place'];
    $birth_date = $_POST['birth_date'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hint = $_POST['password_hint'];

    // Validasi
    if (empty($ktp) || !ctype_digit($ktp)) {
        $inputErrors['ktp'] = "No. KTP harus diisi dan hanya boleh berisi angka.";
    }
    if (empty($phone) || !ctype_digit($phone)) {
        $inputErrors['phone'] = "No. Handphone harus diisi dan hanya boleh berisi angka.";
    }
    if (empty($fullname)) {
        $inputErrors['fullname'] = "Nama Lengkap harus diisi.";
    }
    if (empty($birth_place)) {
        $inputErrors['birth_place'] = "Tempat Lahir harus diisi.";
    }
    if (empty($birth_date)) {
        $inputErrors['birth_date'] = "Tanggal Lahir harus diisi.";
    }
    if (empty($username)) {
        $inputErrors['username'] = "Username harus diisi.";
    }
    if (empty($password)) {
        $inputErrors['password'] = "Password harus diisi.";
    }
    if (empty($password_hint)) {
        $inputErrors['password_hint'] = "Hint Lupa Password harus diisi.";
    }

    // Jika tidak ada error, simpan data
    if (empty($inputErrors)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (, ktp, phone, fullname, birth_place, birth_date, username, password, password_hint) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$ktp, $phone, $fullname, $birth_place, $birth_date, $username, $password_hashed, $password_hint]);

        header('Location: login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/bg-img.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .register-box {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
        }
        .register-box h2 {
            margin-bottom: 20px;
        }
        .headline-box {
            max-width: 500px;
            margin-right: 20px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .container {
            padding-top: 50px;
            padding-bottom: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container .row {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        label {
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .error-text {
            color: red;
            font-size: 0.875rem;
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

        @media (max-width: 767.98px) {
            .register-box, .headline-box {
                margin: 10px auto;
            }
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Headline di Samping Register -->
        <div class="headline-box">
            <h1>Selamat Datang di Website Digital Desa</h1>
            <p>Silakan daftar untuk mengakses fitur digital desa kami dan mempermudah urusan Anda.</p>
        </div>

        <!-- Kotak Register -->
        <div class="register-box">
        <h2 class="text-center link-green">Register</h2>
        <hr style="color:green;">
            <!-- Tampilkan error jika ada -->
            <?php if (!empty($inputErrors)): ?>
                <div class="alert alert-danger" role="alert">
                    Harap periksa kembali input Anda.
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php">
            <!-- No. KTP -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="ktp" class="form-label me-3" style="min-width: 150px;">No. KTP:</label>
                    <input type="text" name="ktp" id="ktp" class="form-control <?= isset($inputErrors['ktp']) ? 'is-invalid' : '' ?>" value="<?= isset($ktp) ? $ktp : '' ?>">
                </div>
                <?php if (isset($inputErrors['ktp'])): ?>
                    <span class="error-text"><?= $inputErrors['ktp'] ?></span>
                <?php endif; ?>
            </div>

            <!-- No. Handphone -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="phone" class="form-label me-3" style="min-width: 150px;">No. Handphone:</label>
                    <input type="text" name="phone" id="phone" class="form-control <?= isset($inputErrors['phone']) ? 'is-invalid' : '' ?>" value="<?= isset($phone) ? $phone : '' ?>">
                </div>
                <?php if (isset($inputErrors['phone'])): ?>
                    <span class="error-text"><?= $inputErrors['phone'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Nama Lengkap -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="fullname" class="form-label me-3" style="min-width: 150px;">Nama Lengkap:</label>
                    <input type="text" name="fullname" id="fullname" class="form-control <?= isset($inputErrors['fullname']) ? 'is-invalid' : '' ?>" value="<?= isset($fullname) ? $fullname : '' ?>">
                </div>
                <?php if (isset($inputErrors['fullname'])): ?>
                    <span class="error-text"><?= $inputErrors['fullname'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="birth_place" class="form-label me-3" style="min-width: 150px;">Tempat Lahir:</label>
                    <input type="text" name="birth_place" id="birth_place" class="form-control <?= isset($inputErrors['birth_place']) ? 'is-invalid' : '' ?>" value="<?= isset($birth_place) ? $birth_place : '' ?>">
                </div>
                <?php if (isset($inputErrors['birth_place'])): ?>
                    <span class="error-text"><?= $inputErrors['birth_place'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="birth_date" class="form-label me-3" style="min-width: 150px;">Tanggal Lahir:</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control <?= isset($inputErrors['birth_date']) ? 'is-invalid' : '' ?>" value="<?= isset($birth_date) ? $birth_date : '' ?>">
                </div>
                <?php if (isset($inputErrors['birth_date'])): ?>
                    <span class="error-text"><?= $inputErrors['birth_date'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="username" class="form-label me-3" style="min-width: 150px;">Username:</label>
                    <input type="text" name="username" id="username" class="form-control <?= isset($inputErrors['username']) ? 'is-invalid' : '' ?>" value="<?= isset($username) ? $username : '' ?>">
                </div>
                <?php if (isset($inputErrors['username'])): ?>
                    <span class="error-text"><?= $inputErrors['username'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="password" class="form-label me-3" style="min-width: 150px;">Password:</label>
                    <input type="password" name="password" id="password" class="form-control <?= isset($inputErrors['password']) ? 'is-invalid' : '' ?>">
                </div>
                <?php if (isset($inputErrors['password'])): ?>
                    <span class="error-text"><?= $inputErrors['password'] ?></span>
                <?php endif; ?>
            </div>

            <!-- password_hint Lupa Password -->
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="password_hint" class="form-label me-3" style="min-width: 150px;">Hint untuk Lupa Password:</label>
                    <input type="text" name="password_hint" id="password_hint" class="form-control <?= isset($inputErrors['password_hint']) ? 'is-invalid' : '' ?>" value="<?= isset($password_hint) ? $password_hint : '' ?>">
                </div>
                <?php if (isset($inputErrors['password_hint'])): ?>
                    <span class="error-text"><?= $inputErrors['password_hint'] ?></span>
                <?php endif; ?>
            </div>

                <!-- Button Register -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-green">Register</button>
                </div>
                <hr style="color:green;">

                <!-- Link ke Login -->
                <p class="text-center mt-3">
                    Sudah punya akun?
                    <a href="login.php" class="link-green">Login Di sini</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
