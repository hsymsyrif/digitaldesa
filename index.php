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
    <style>
        /* Navbar transparent with scroll effect */
        .navbar {
            background-color: transparent;
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

    <!-- Hero Section -->
    <section class="bg-hero flex justify-center items-center gradient-overlay text-white container-padding" data-aos="fade-up" style="background-image: url('img/bg-img.jpg'); background-size: cover; background-position: center; height: 100vh;">
    <div class="text-center" style="position: relative; z-index: 2;">
        <h1 class="text-5xl font-bold mb-6 smooth-transition">Selamat Datang di MustiDigi</h1>
        <p class="text-xl mb-10 smooth-transition">Solusi Terdepan untuk Pengelolaan Desa Digital</p>
        <a href="#about" class="btn-primary text-white py-3 px-6 rounded-lg text-lg hover:shadow-lg">Pelajari Lebih Lanjut</a>
    </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-white" data-aos="fade-right">
        <div class="container mx-auto text-center container-padding">
            <h2 class="text-4xl font-bold text-black mb-6 text-center">Tentang MustiDigi</h2>
            <p class="text-lg text-gray-700 mb-12">MustiDigi adalah platform inovatif yang berkomitmen untuk membawa perubahan digital di tingkat desa. Kami menyediakan berbagai layanan yang membantu pengelolaan desa secara efisien, transparan, dan modern.</p>
            <div class="flex justify-center space-x-6">
                <div class="w-full md:w-1/3 p-4 shadow-lg rounded-lg btn-primary text-white">
                    <h3 class="text-2xl font-bold text-green-custom mb-4">Misi Kami</h3>
                    <p class="text-white">Mengoptimalkan manajemen desa melalui teknologi digital yang mudah digunakan dan terintegrasi.</p>
                </div>
                <div class="w-full md:w-1/3 p-4 shadow-lg rounded-lg btn-primary">
                    <h3 class="text-2xl font-bold text-white mb-4">Visi Kami</h3>
                    <p class="text-white">Mewujudkan desa-desa cerdas yang siap menghadapi era digital dengan tata kelola yang efektif dan modern.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-100" data-aos="fade-left">
        <div class="container mx-auto text-center container-padding">
            <h2 class="text-4xl font-bold text-black mb-6 text-center">Layanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md smooth-transition hover:shadow-xl">
                    <h3 class="text-2xl font-semibold text-green-custom mb-4">Layanan Administrasi</h3>
                    <p class="text-gray-700">Kami memudahkan pengelolaan administrasi desa dengan sistem yang terintegrasi dan user-friendly.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md smooth-transition hover:shadow-xl">
                    <h3 class="text-2xl font-semibold text-green-custom mb-4">Pengelolaan Pajak PBB-P2</h3>
                    <p class="text-gray-700">Optimalkan pengumpulan pajak dengan sistem pengelolaan PBB-P2 yang efisien.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md smooth-transition hover:shadow-xl">
                    <h3 class="text-2xl font-semibold text-green-custom mb-4">Manajemen Bansos</h3>
                    <p class="text-gray-700">Manajemen bantuan sosial yang transparan dan tepat sasaran dengan solusi kami.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md smooth-transition hover:shadow-xl">
                    <h3 class="text-2xl font-semibold text-green-custom mb-4">Website Profil Desa</h3>
                    <p class="text-gray-700">Bangun website profil desa yang informatif dan menarik dengan solusi kami.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md smooth-transition hover:shadow-xl">
                    <h3 class="text-2xl font-semibold text-green-custom mb-4">Siskuedes Online</h3>
                    <p class="text-gray-700">Sistem keuangan desa online yang memudahkan pencatatan dan pelaporan keuangan desa.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md smooth-transition hover:shadow-xl">
                    <h3 class="text-2xl font-semibold text-green-custom mb-4">Pantauan Dashboard</h3>
                    <p class="text-gray-700">Pantau kinerja desa dari kecamatan dan kabupaten melalui dashboard yang terintegrasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Administrasi Desa Section -->
    <section id="administrasi-desa" class="py-24 bg-white smooth-transition" data-aos="fade-up" data-aos-duration="800">
        <div class="container mx-auto px-6 lg:px-12">
            <h2 class="text-4xl font-bold text-black mb-6 text-center">Layanan Administrasi Desa</h2>
            <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-16">
                Kami menyediakan layanan administrasi untuk mempermudah warga desa dalam mengurus berbagai kebutuhan administratif. Semua layanan tersedia secara gratis, mudah diakses, dan diproses dengan cepat.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10" data-aos="fade-up" data-aos-duration="800">
                <!-- ID Card -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-2 duration-300" data-aos="flip-left" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <img src="img/id-card.svg" alt="Icon KTP" class="h-10 w-10 mr-3">
                        <h3 class="text-2xl font-semibold text-green-700">Pembuatan KTP</h3>
                    </div>
                    <p class="text-gray-700 mb-6">Layanan pembuatan KTP baru atau pembaruan bagi warga desa.</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li>Persyaratan: Kartu Keluarga, Akta Kelahiran</li>
                        <li>Estimasi Waktu: 7-14 hari kerja</li>
                        <li>Biaya: Gratis</li>
                    </ul>
                    <p class="text-gray-500 text-sm">Termasuk pengisian formulir, verifikasi data, dan pengambilan foto.</p>
                </div>

                <!-- Layanan Pengurusan KK -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-2 duration-300" data-aos="flip-left" data-aos-delay="300">
                    <div class="flex items-center mb-6">
                        <img src="img/id-card.svg" alt="Icon KK" class="h-10 w-10 mr-3">
                        <h3 class="text-2xl font-semibold text-green-700">Pengurusan Kartu Keluarga</h3>
                    </div>
                    <p class="text-gray-700 mb-6">Pengurusan KK bagi keluarga baru atau yang menambah anggota.</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li>Persyaratan: Surat Nikah, Akta Lahir</li>
                        <li>Estimasi Waktu: 7-10 hari kerja</li>
                        <li>Biaya: Gratis</li>
                    </ul>
                    <p class="text-gray-500 text-sm">Diperlukan untuk administrasi lainnya, seperti pendaftaran sekolah.</p>
                </div>

                <!-- Layanan Surat Pengantar -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-2 duration-300" data-aos="flip-left" data-aos-delay="400">
                    <div class="flex items-center mb-6">
                        <img src="img/surat-pengantar.svg" alt="Icon Surat Pengantar" class="h-10 w-10 mr-3">
                        <h3 class="text-2xl font-semibold text-green-700">Pembuatan Surat Pengantar</h3>
                    </div>
                    <p class="text-gray-700 mb-6">Surat pengantar resmi untuk keperluan seperti pekerjaan dan pendaftaran sekolah.</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li>Persyaratan: KTP, KK</li>
                        <li>Estimasi Waktu: 1-2 hari kerja</li>
                        <li>Biaya: Gratis</li>
                    </ul>
                    <p class="text-gray-500 text-sm">Diperlukan untuk memenuhi persyaratan administratif formal.</p>
                </div>

                <!-- Layanan Surat Keterangan Usaha -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-2 duration-300" data-aos="flip-left" data-aos-delay="500">
                    <div class="flex items-center mb-6">
                        <img src="img/surat-pengantar.svg" alt="Icon SKU" class="h-10 w-10 mr-3">
                        <h3 class="text-2xl font-semibold text-green-700">Surat Keterangan Usaha</h3>
                    </div>
                    <p class="text-gray-700 mb-6">Surat keterangan usaha untuk bukti kepemilikan usaha di desa.</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li>Persyaratan: KTP, Bukti Usaha</li>
                        <li>Estimasi Waktu: 3-5 hari kerja</li>
                        <li>Biaya: Gratis</li>
                    </ul>
                    <p class="text-gray-500 text-sm">Digunakan untuk pengajuan modal atau kredit usaha.</p>
                </div>

                <!-- Layanan Surat Keterangan Domisili -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-2 duration-300" data-aos="flip-left" data-aos-delay="600">
                    <div class="flex items-center mb-6">
                        <img src="img/surat-pengantar.svg" alt="Icon Surat Domisili" class="h-10 w-10 mr-3">
                        <h3 class="text-2xl font-semibold text-green-700">Surat Keterangan Domisili</h3>
                    </div>
                    <p class="text-gray-700 mb-6">Surat domisili untuk pendaftaran sekolah, pekerjaan, dan lainnya.</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li>Persyaratan: KTP, KK</li>
                        <li>Estimasi Waktu: 1-3 hari kerja</li>
                        <li>Biaya: Gratis</li>
                    </ul>
                    <p class="text-gray-500 text-sm">Bukti tempat tinggal untuk keperluan formal.</p>
                </div>

                <!-- Layanan Surat Izin Keramaian -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-2 duration-300" data-aos="flip-left" data-aos-delay="700">
                    <div class="flex items-center mb-6">
                        <img src="img/surat-pengantar.svg" alt="Icon Izin Keramaian" class="h-10 w-10 mr-3">
                        <h3 class="text-2xl font-semibold text-green-700">Surat Izin Keramaian</h3>
                    </div>
                    <p class="text-gray-700 mb-6">Izin keramaian untuk acara yang melibatkan banyak orang.</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li>Persyaratan: KTP, Detail Acara</li>
                        <li>Estimasi Waktu: 2-3 hari kerja</li>
                        <li>Biaya: Gratis</li>
                    </ul>
                    <p class="text-gray-500 text-sm">Diperlukan untuk menjaga ketertiban acara publik di desa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pelayanan Desa Section -->
    <section id="pelayanan-desa" class="py-24 bg-gray-50 container-padding">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-black mb-6 text-center" data-aos="fade-up" data-aos-duration="800">Pelayanan Desa</h2>
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

    <!-- Perpajakan Section -->
    <section id="perpajakan" class="bg-white py-24 px-4 container-padding">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold text-black mb-6 text-center">Perpajakan Desa</h2>
            <p class="text-lg text-gray-700 text-center mb-10">
                Kami menyediakan informasi lengkap tentang kewajiban perpajakan desa, termasuk PBB-P2 (Pajak Bumi dan Bangunan Perdesaan dan Perkotaan) serta panduan untuk warga desa. Pelajari lebih lanjut mengenai jenis-jenis pajak dan cara pembayarannya.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- PBB-P2 Card -->
                <div class="bg-green-100 p-6 rounded-lg shadow-md hover:shadow-lg smooth-transition" data-aos="flip-left" data-aos-delay="100">
                    <h3 class="text-2xl font-semibold text-green-800 mb-4">PBB-P2</h3>
                    <p class="text-gray-700 mb-4">
                        Pajak Bumi dan Bangunan Perdesaan dan Perkotaan (PBB-P2) merupakan pajak atas tanah dan/atau bangunan yang wajib dibayar oleh pemilik atau pengguna tanah dan bangunan yang ada di wilayah desa kami.
                    </p>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Mendukung pembangunan desa</li>
                        <li>Kontribusi terhadap pengembangan fasilitas umum</li>
                        <li>Mudah dibayar secara online maupun offline</li>
                    </ul>
                </div>

                <!-- Cara Pembayaran Card -->
                <div class="bg-green-100 p-6 rounded-lg shadow-md hover:shadow-lg smooth-transition" data-aos="flip-left" data-aos-delay="200">
                    <h3 class="text-2xl font-semibold text-green-800 mb-4">Cara Pembayaran Pajak</h3>
                    <p class="text-gray-700 mb-4">
                        Pembayaran pajak kini semakin mudah! Anda dapat membayar melalui bank, kantor pos, atau platform online resmi. Ikuti langkah-langkah berikut:
                    </p>
                    <ol class="list-decimal list-inside text-gray-700">
                        <li>Siapkan nomor objek pajak (NOP) Anda.</li>
                        <li>Pilih metode pembayaran yang Anda inginkan.</li>
                        <li>Konfirmasi pembayaran dan simpan bukti pembayaran Anda.</li>
                    </ol>
                </div>
            </div>

            <!-- Informasi Bantuan -->
            <div class="mt-12 p-8 bg-green-50 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-3xl font-bold text-green-700 mb-4">Bantuan & Informasi Pajak</h3>
                <p class="text-gray-700 mb-6">
                    Untuk informasi lebih lanjut atau bantuan terkait pajak, warga desa dapat menghubungi kantor desa atau kunjungi website resmi kami. Kami siap membantu Anda dalam memahami dan memenuhi kewajiban perpajakan.
                </p>
                <a href="kontak.php" class="text-lg bg-green-500 text-white py-2 px-5 rounded-lg hover:bg-green-600 transition-all duration-300">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Bantuan Sosial Section -->
    <section id="bansos" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6 lg:px-16">
            <h2 class="text-4xl font-bold text-black mb-6 text-center" data-aos="fade-up" data-aos-duration="1000">
                Bantuan Sosial
            </h2>
            <p class="text-lg text-center text-gray-600 mb-12" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                Informasi lengkap mengenai program bantuan sosial yang tersedia untuk masyarakat desa. Lihat jenis bantuan yang tersedia, persyaratan, dan cara mendaftar.
            </p>

            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                <!-- Bantuan 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300" data-aos="zoom-in" data-aos-delay="100">
                    <h3 class="text-2xl font-semibold text-green-600 mb-3">Bantuan Keluarga Harapan (PKH)</h3>
                    <p class="text-gray-700 mb-4">
                        Program ini bertujuan untuk membantu keluarga miskin dalam memenuhi kebutuhan dasar mereka, seperti pendidikan dan kesehatan.
                    </p>
                    <ul class="text-gray-600 list-disc list-inside mb-4">
                        <li>Persyaratan: Keluarga miskin dengan anak sekolah</li>
                        <li>Bantuan: Dana tunai bulanan</li>
                        <li>Lokasi: Kantor Desa</li>
                    </ul>
                </div>

                <!-- Bantuan 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300" data-aos="zoom-in" data-aos-delay="200">
                    <h3 class="text-2xl font-semibold text-green-600 mb-3">Bantuan Pangan Non-Tunai (BPNT)</h3>
                    <p class="text-gray-700 mb-4">
                        Program yang menyediakan bantuan pangan untuk masyarakat kurang mampu dengan menggunakan e-voucher.
                    </p>
                    <ul class="text-gray-600 list-disc list-inside mb-4">
                        <li>Persyaratan: Warga prasejahtera</li>
                        <li>Bantuan: E-voucher untuk kebutuhan pangan</li>
                        <li>Lokasi: Kantor Desa</li>
                    </ul>
                </div>

                <!-- Bantuan 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300" data-aos="zoom-in" data-aos-delay="300">
                    <h3 class="text-2xl font-semibold text-green-600 mb-3">Bantuan Sosial Tunai (BST)</h3>
                    <p class="text-gray-700 mb-4">
                        Program ini memberikan bantuan dana tunai bagi warga terdampak pandemi COVID-19 yang tidak memiliki penghasilan tetap.
                    </p>
                    <ul class="text-gray-600 list-disc list-inside mb-4">
                        <li>Persyaratan: Warga terdampak pandemi</li>
                        <li>Bantuan: Dana tunai satu kali</li>
                        <li>Lokasi: Kantor Desa</li>
                    </ul>
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
