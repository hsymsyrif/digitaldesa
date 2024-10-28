<?php
session_start();

// Database connection
$host = '127.0.0.1';  // Replace with your DB host if needed
$dbname = 'user_management'; // Your database name
$username = 'root';  // Replace with your DB username
$password = '';  // Replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the user data from the database based on the logged-in user's ID
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

$query = "SELECT fullname, ktp, phone, birth_place, birth_date, username FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// If no user data is found, redirect to login or handle appropriately
if (!$user_data) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MustiDigi - Inovasi Digital Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Navbar transparent with scroll effect */
        /* Navbar */
        .navbar {
            background-color: rgba(56, 178, 172, 0.9); /* Set permanent background color */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease-in-out;
        }

        .navbar.scrolled {
            background-color: rgba(56, 178, 172, 0.9); /* Greenish background when scrolled */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            min-width: 150px;
            z-index: 1;
            border-radius: 0.5rem;
            padding: 0.5rem;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .desktop-menu {
                display: none; /* Hide desktop menu on mobile */
            }

            .mobile-menu {
                display: block; /* Show mobile menu button on mobile */
            }

            .mobile-menu.active {
                display: block; /* Ensure mobile menu opens */
            }

            .dropdown-content {
                position: static;
                box-shadow: none;
                min-width: 100%;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu {
                display: none; /* Hide mobile menu on larger screens */
            }
        }

        /* Overlay Gradient for better contrast */
        .gradient-overlay {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.2));
        }

        /* Custom colors */
        .bg-green-custom {
            background-color: #38b2ac; /* Brighter green */
        }

        .btn-primary {
            background-color: #38b2ac; /* Bright green */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition */
        }

        .btn-primary:hover {
            background-color: #2f855a;
            transform: scale(1.05); /* Button hover animation */
        }

        /* Smooth transition for elements */
        .smooth-transition {
            transition: all 0.6s ease; /* Softer animation */
        }

        /* Container Padding */
        .container-padding {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Scroll-to-top button */
        .scroll-to-top {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background-color: #48bb78;
            padding: 12px;
            border-radius: 10%;
            color: white;
            cursor: pointer;
            display: none;
            z-index: 100;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .scroll-to-top:hover {
            background-color: #2f855a;
            transform: scale(1.1);
        }

        /* Media Query for larger devices */
        @media (min-width: 1024px) {
            .container-padding {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100 smooth-transition">

    <!-- Navbar -->
    <nav class="navbar p-4 fixed w-full z-10 flex justify-between items-center">
        <a href="index.php" class="text-3xl font-bold text-white">MustiDigi</a>
        <div class="desktop-menu flex items-center space-x-6">
            <a href="index.php" class="text-white text-lg hover:text-green-400">Beranda</a>
            <a href="index.php#about" class="text-white text-lg hover:text-green-400">Tentang Kami</a>
            <div class="relative dropdown">
                <a href="#" class="text-white text-lg hover:text-green-400">Layanan &#x2BC6;</a>
                <div class="dropdown-content">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Administrasi Desa</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Pelayanan Desa</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perpajakan (PBB-P2)</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Bantuan Sosial</a>
                </div>
            </div>
            <a href="kontak.php" class="text-white text-lg hover:text-green-400">Kontak</a>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="profile.php" class="text-white text-lg hover:text-green-400">Profile</a>
            <?php else : ?>
                <a href="login.php" class="text-white text-lg hover:text-green-400">Login</a>
                <a href="register.php" class="text-lg bg-green-500 text-white py-2 px-5 rounded-lg hover:bg-green-600">Register</a>
            <?php endif; ?>
        </div>
        <button class="mobile-menu text-white" id="menu-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden bg-green-custom fixed w-full z-20 top-0 left-0 right-0" id="mobile-menu">
        <div class="flex flex-col items-center space-y-4 p-4">
            <a href="index.php" class="text-white text-lg">Beranda</a>
            <a href="#about" class="text-white text-lg">Tentang Kami</a>
            <div class="relative dropdown">
                <a href="#" class="text-white text-lg">Layanan &#x2BC6;</a>
                <div class="dropdown-content bg-green-200 w-full">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Administrasi Desa</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Pelayanan Desa</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perpajakan (PBB-P2)</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Bantuan Sosial</a>
                </div>
            </div>
            <a href="kontak.php" class="text-white text-lg">Kontak</a>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="profile.php" class="text-white text-lg">Profile</a>
            <?php else : ?>
                <a href="login.php" class="text-white text-lg">Login</a>
                <a href="register.php" class="text-lg bg-green-500 text-white py-2 px-5 rounded-lg">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Profile Section -->
    <section class="py-24 bg-gradient-to-b from-teal-300 via-teal-100 to-white">
        <div class="container mx-auto max-w-4xl px-6">
            <!-- White Box Container -->
            <div class="profile-section bg-white rounded-[2.5rem] shadow-2xl p-12 mt-16 relative">
                <!-- Decorative Top Bar -->
                <div class="absolute inset-x-0 -top-6 mx-auto h-2 w-32 bg-teal-600 rounded-full"></div>

                <!-- Profile Title -->
                <h2 class="text-5xl font-extrabold text-teal-800 mb-12 text-center drop-shadow-lg tracking-tight">
                    Profil Pengguna
                </h2>

                <!-- Profile Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                    <!-- Fullname -->
                    <div class="flex items-center space-x-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="text-teal-600">
                            <i class="fas fa-user-circle text-4xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Nama Lengkap</h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($user_data['fullname']); ?></p>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="flex items-center space-x-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="text-teal-600">
                            <i class="fas fa-user text-4xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Username</h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($user_data['username']); ?></p>
                        </div>
                    </div>

                    <!-- No. KTP -->
                    <div class="flex items-center space-x-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="text-teal-600">
                            <i class="fas fa-id-card text-4xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">No. KTP</h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($user_data['ktp']); ?></p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-center space-x-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="text-teal-600">
                            <i class="fas fa-phone text-4xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Telepon</h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($user_data['phone']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Edit and Logout Buttons -->
                <div class="mt-12 text-center space-x-4">
                    <a href="edit_profile.php" class="inline-block bg-teal-600 text-white font-semibold py-3 px-10 rounded-full hover:bg-teal-700 transition-transform transform hover:scale-105 duration-300 shadow-md">
                        Edit Profil
                    </a>
                    <a href="logout.php" class="inline-block bg-red-500 text-white font-semibold py-3 px-10 rounded-full hover:bg-red-600 transition-transform transform hover:scale-105 duration-300 shadow-md">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Scroll-to-top Button -->
    <button class="scroll-to-top" id="scrollToTopBtn">
        &#x2BC5;
    </button>

    <!-- Footer -->
    <footer class="bg-green-custom text-white py-10">
        <div class="container mx-auto text-center container-padding">
            <!-- Horizontal Line -->
            <hr class="border-t border-white-700 my-6">
            <p class="mt-6">&copy; 2024 MustiDigi. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Mobile menu toggle
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('active');
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        AOS.init();

        // Scroll-to-top functionality
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollToTopBtn.style.display = 'block';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>

</html>
