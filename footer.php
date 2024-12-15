<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Katering</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        footer {
            background-color: #333;
            color: #fff;
            padding: 50px 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
        }

        .column {
            flex: 1;
            padding: 0 20px;
            text-align: justify;
            line-height: 1.5;
        }

        .footer-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .social-media {
            list-style: none;
            display: flex;
        }

        .social-media li {
            margin-right: 10px;
        }

        .social-media a {
            color: #fff;
            font-size: 24px;
            transition: transform 0.3s ease-in-out;
        }

        .social-media a:hover {
            transform: scale(1.2);
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        /* Add a subtle hover effect to links */
        a {
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <footer>
        <div class="container">
            <div class="column">
                <h3 class="footer-title">Don't Miss Out</h3>
                <p>Daftar untuk mendapatkan menu terbaru, promo menarik, dan tips memasak!</p>
                <form id="newsletter-form">
                    <input type="email" id="email" placeholder="Alamat Email Anda">
                    <button type="submit">Daftar</button>
                </form>
                <p>Dengan mendaftar, Anda menyetujui kebijakan privasi kami.</p>
            </div>
            <div class="column">
                <h3 class="footer-title">Tentang Kami</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">Lokasi</a></li>
                    <li><a href="#">Galeri</a></li>
                </ul>
            </div>
            <div class="column">
                <h3 class="footer-title">Layanan Pelanggan</h3>
                <ul>
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Pesanan</a></li>
                </ul>
            </div>
            <div class="column">
                <h3 class="footer-title">Ikuti Kami</h3>
                <ul class="social-media">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2024 Catering. All rights reserved.
        </div>
    </footer>

    <script>
        // Skrip JavaScript untuk formulir newsletter
        const newsletterForm = document.getElementById('newsletter-form');
        newsletterForm.addEventListener('submit', (event) => {
            event.preventDefault();
            // Tambahkan logika untuk mengirimkan data formulir ke server
            alert('Terima kasih telah berlangganan!');
        });
    </script>
</body>
</html>