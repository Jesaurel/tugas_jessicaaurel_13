<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Lezat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Reset */
        body,
        h1,
        h2,
        h3,
        p,
        ul,
        li,
        a {
            margin: 0;
            padding: 0;
            text-decoration: none;
            list-style: none;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: #fff;
        }

        /* Header */
        header {
            width: 100%;
            background: linear-gradient(to right, #4b0082, #8b0000);
            /* Purple to dark red */
            position: relative;
            top: 0;
            left: 0;
            height: 80px;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .top-bar {
            background-color: rgba(218, 165, 32, 0.8);
            /* Gold color */
            padding: 5px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .top-bar .contact-info {
            display: flex;
            gap: 15px;
        }

        .top-bar .social-icons a {
            color: #fff;
            margin-left: 10px;
        }

        /* Main Header */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            height: 60px;
        }

        .logo a {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        /* Menu */
        .menu {
            display: flex;
            gap: 20px;
        }

        .menu li a {
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .menu li a:hover {
            color: rgba(218, 165, 32, 0.8);
            /* Gold hover effect */
        }

        /* Header Right */
        .header-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .contact-number {
            font-size: 16px;
            font-weight: bold;
            display: block;
            color: #fff;
        }

        .cart-icon {
            font-size: 20px;
            color: #fff;
        }

        .checkout-btn {
            background-color: rgba(218, 165, 32, 0.8);
            padding: 5px 15px;
            font-size: 14px;
            font-weight: bold;
            color: #111;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .checkout-btn:hover {
            background-color: rgba(255, 215, 0, 0.8);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            width: 250px;
            background-color: #4b0082;
            padding-top: 60px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            transition: left 0.4s ease;
            z-index: 2;
            /* Added z-index property */
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar a {
            color: #fff;
            padding: 10px;
            text-align: center;
            display: block;
            font-size: 18px;
            transition: background-color 0.3s;
        }


        .sidebar a:hover {
            background-color: rgba(218, 165, 32, 0.8);
        }

        /* Burger Icon for Mobile */
        .burger-icon {
            display: none;
            font-size: 30px;
            color: #fff;
            cursor: pointer;
            transition: transform 0.4s ease;
        }

        .burger-icon.cross {
            transform: rotate(45deg);
        }

        /* Mobile Styles */
        @media screen and (max-width: 768px) {
            .menu {
                display: none;
            }

            .burger-icon {
                display: block;
            }

            .header-right {
                display: none;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="top-bar">
            <p>Free Delivery on all orders Over $50</p>
            <div class="contact-info">
                <span>Rd. Alerviews, New Mexico 31134</span>
                <span class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </span>
            </div>
        </div>
        <div class="main-header">
            <div class="logo">
                <a href="../index.php">Catering Lezat</a>
            </div>
            <nav>
                <ul class="menu">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="user/menu.php">Menu</a></li>
                    <li><a href="user/galeri.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <span class="contact-number">+123 (302) 555-51</span>
                <a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
                <a href="../user/checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
            <div class="burger-icon" id="burger" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <div class="sidebar" id="sidebar">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="galeri.php">Gallery</a>
        <a href="profile.php">Contact</a>
        <a href="checkout.php">Checkout</a>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const burger = document.getElementById('burger');
            sidebar.classList.toggle('active');
            burger.classList.toggle('cross');
        }
    </script>

</body>

</html>