<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MustiDigi - Inovasi Digital Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMqt68GAlmyV2gyhWy5nHp5jGk/aZSTN3zvHeWi" crossorigin="anonymous">
    <style>
        /* Navbar transparent with scroll effect */
        .navbar {
            background-color: #38b2ac;
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

    .bg-hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4); /* Overlay hitam dengan opacity */
        z-index: 1;
    }

    .bg-hero {
        position: relative;
        z-index: 2;
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
                    <a href="menuadmin.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Administrasi Desa</a>
                    <a href="pelayanan.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Pelayanan Desa</a>
                    <a href="perpajakan.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perpajakan (PBB-P2)</a>
                    <a href="bansos.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Bantuan Sosial</a>
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
                    <a href="menuadmin.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Administrasi Desa</a>
                    <a href="pelayanan.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Pelayanan Desa</a>
                    <a href="perpajakan.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perpajakan (PBB-P2)</a>
                    <a href="bansos.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Bantuan Sosial</a>
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

    <!-- Pelayanan Desa Section -->
    <section id="pelayanan-desa" class="py-24 bg-gray-50 container-padding">
        <div class="container mx-auto text-center">
            <h2 class="text-5xl font-bold text-green-600 mb-6" data-aos="fade-up" data-aos-duration="800">Pelayanan Desa</h2>
            <p class="text-xl text-gray-700 mb-12" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                Kami menyediakan berbagai layanan untuk kemudahan masyarakat desa.
            </p>
            
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Service Item 1 -->
                <div class="service-item bg-white rounded-lg shadow-lg p-6 transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                    <div class="text-green-600 text-5xl mb-4 animate-pulse">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Administrasi Desa</h3>
                    <p class="text-gray-600 mb-4">
                        Memudahkan pengurusan administrasi seperti pembuatan KTP, KK, dan surat-surat penting.
                    </p>
                    <a href="menuadmin.php" class="inline-block bg-green-500 text-white py-2 px-4 rounded-lg transition duration-300 hover:bg-green-600">Learn More</a>
                </div>
                
                <!-- Service Item 2 -->
                <div class="service-item bg-white rounded-lg shadow-lg p-6 transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                    <div class="text-green-600 text-5xl mb-4 animate-pulse">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Bantuan Sosial</h3>
                    <p class="text-gray-600 mb-4">
                        Program bantuan sosial untuk mendukung warga desa yang membutuhkan.
                    </p>
                    <a href="bansos.php" class="inline-block bg-green-500 text-white py-2 px-4 rounded-lg transition duration-300 hover:bg-green-600">Learn More</a>
                </div>

                <!-- Service Item 3 -->
                <div class="service-item bg-white rounded-lg shadow-lg p-6 transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                    <div class="text-green-600 text-5xl mb-4 animate-pulse">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Perpajakan Desa</h3>
                    <p class="text-gray-600 mb-4">
                        Layanan perpajakan (PBB-P2) untuk membantu warga desa dalam proses pembayaran pajak.
                    </p>
                    <a href="perpajakan.php" class="inline-block bg-green-500 text-white py-2 px-4 rounded-lg transition duration-300 hover:bg-green-600">Learn More</a>
                </div>

                <!-- Service Item 4 -->
                <div class="service-item bg-white rounded-lg shadow-lg p-6 transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                    <div class="text-green-600 text-5xl mb-4 animate-pulse">
                        <i class="fas fa-people-carry"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Pelayanan Masyarakat</h3>
                    <p class="text-gray-600 mb-4">
                        Layanan konsultasi dan bantuan bagi warga desa untuk keperluan sehari-hari.
                    </p>
                    <a href="pelayanan.php" class="inline-block bg-green-500 text-white py-2 px-4 rounded-lg transition duration-300 hover:bg-green-600">Learn More</a>
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
