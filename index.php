<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "Jess1_MySql!";
$dbname = "jessicaaurelclarista_13_catering";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$isLoggedIn = isset($_SESSION['user_email']);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Lezat</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body>
<header>
    <div class="header-container">

        <div class="logo">
            <img src="assets/images/logo.png" alt="Catering Lezat Logo">
            <h1>Catering Lezat</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#paket">Paket Catering</a></li>
                <li><a href="#kontak">Kontak</a></li>
                <li><a href="#tentang-kami">Tentang Kami</a></li>
            </ul>
        </nav>
        <!-- Tombol Login -->
        <div class="login-btn">
            <?php if ($isLoggedIn): ?>
                <a href="profile.php" class="cta-btn">Profil</a>
                <a href="logout.php" class="cta-btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn">Login</a>
            <?php endif; ?>
            <a href="contact.php" class="btn">Kontak Kami</a>
        </div>
    </div>
</header>


    <!-- Hero Section -->
    <section class="hero" style="background-image: url('assets/images/food_background.jpg');">
        <div class="hero-content">
            <?php if (isset($_SESSION['user_email'])): ?>
                <p class="greeting">
                    Halo, <?php echo $userName; ?>! Selamat datang kembali di Catering Lezat.
                </p>
            <?php endif; ?>
            <h1>Solusi Catering Lezat untuk Setiap Acara</h1>
            <p>Rasakan hidangan terbaik dengan pelayanan profesional kami</p>
            <div class="hero-buttons">
                <a href="#menu" class="cta-btn cta-primary">Mulai Pesan Sekarang</a>
                <a href="#paket" class="cta-btn cta-secondary">Lihat Promo Terbaik</a>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang-kami" class="about-us">
        <div class="about-content">
            <div class="text">
                <h2>Tentang Kami</h2>
                <p>Catering Lezat hadir untuk memberikan solusi kuliner terbaik untuk setiap acara Anda. Kami menggunakan bahan berkualitas tinggi, koki ahli, dan layanan profesional untuk memastikan pengalaman terbaik.</p>
                <a href="#why-choose-us" class="cta-btn">Kenapa Memilih Kami?</a>
            </div>
            <div class="image">
                <img src="assets/images/Food Vlogger.gif" alt="Tentang Catering Lezat">
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why-choose-us" class="why-choose-us">
        <h2>Kenapa Memilih Catering Lezat?</h2>
        <div class="features">
            <div class="feature">
                <img src="/assets/images/icon-ingredients.png" alt="Bahan Berkualitas">
                <p>Bahan Berkualitas</p>
            </div>
            <div class="feature">
                <img src="/assets/images/icon-chef.png" alt="Koki Ahli">
                <p>Koki Ahli</p>
            </div>
            <div class="feature">
                <img src="/assets/images/icon-delivery.png" alt="Pengiriman Cepat">
                <p>Pengiriman Cepat</p>
            </div>
            <div class="feature">
                <img src="/assets/images/icon-service.png" alt="Layanan Profesional">
                <p>Layanan Profesional</p>
            </div>
        </div>
    </section>

    <!-- Paket Catering Section -->
    <section class="catering-packages">
        <h2>Paket Catering</h2>
        <div class="packages">
            <div class="package">
                <div class="image">
                    <img src="assets/images/package-hemat.png" alt="Paket Hemat">
                </div>
                <div class="text">
                    <h3>Paket Hemat</h3>
                    <p>Harga Terjangkau</p>
                    <a href="#" class="cta-btn">Pesan Sekarang</a>
                </div>
            </div>
            <div class="package">
                <div class="image">
                    <img src="assets/images/package-premium.png" alt="Paket Premium">
                </div>
                <div class="text">
                    <h3>Paket Premium</h3>
                    <p>Fitur Lengkap</p>
                    <a href="#" class="cta-btn">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="contact-us">
        <h2>Kontak Kami</h2>
        <p>Hubungi kami untuk informasi lebih lanjut:</p>
        <p>Email: <a href="mailto:contact@cateringlezat.com">contact@cateringlezat.com</a></p>
        <p>Telepon: +62 812-3456-7890</p>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="footer-links">
            <a href="#menu">Menu</a>
            <a href="#paket">Paket Catering</a>
            <a href="#kontak">Kontak</a>
        </div>
        <div class="footer-contact">
            <p>© 2024 Catering Lezat. All rights reserved.</p>
        </div>
    </footer>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>