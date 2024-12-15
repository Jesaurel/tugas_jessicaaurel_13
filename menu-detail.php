<?php
include '../config/db.php';

$menu_id = $_GET['id']; // Get the menu ID from the URL
$query = "SELECT * FROM menu WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .breadcrumbs {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #555;
        }
        .breadcrumbs a {
            text-decoration: none;
            color: #007bff;
        }
        .breadcrumbs span {
            color: #888;
        }
        .menu-detail {
            display: flex;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .menu-image {
            flex: 1;
            padding: 15px;
        }
        .menu-image img {
            max-width: 100%;
            border-radius: 10px;
        }
        .menu-info {
            flex: 2;
            padding: 15px;
        }
        .menu-info h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .menu-info p {
            font-size: 1rem;
            color: #555;
        }
        .price {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
            margin-top: 15px;
        }
        .add-to-cart {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
        }
        .add-to-cart:hover {
            background-color: #0056b3;
        }
        .quantity-container {
            margin-top: 20px;
        }
        .quantity-container input {
            width: 60px;
            padding: 5px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .checkout-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
            width: 100%;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <a href="index.php">Home</a> &gt; <a href="menu.php">Menu</a> &gt; <span><?php echo $menu['name']; ?></span>
        </div>

        <!-- Menu Detail -->
        <div class="menu-detail">
            <!-- Gambar Menu -->
            <div class="menu-image">
                <img src="<?php echo $menu['image_url']; ?>" alt="<?php echo $menu['name']; ?>">
            </div>

            <!-- Info Menu -->
            <div class="menu-info">
                <h2><?php echo $menu['name']; ?></h2>
                <p><strong>Kategori:</strong> <?php echo $menu['category']; ?></p>
                <p><?php echo $menu['description']; ?></p>

                <div class="price">
                    Rp <?php echo number_format($menu['price'], 2, ',', '.'); ?>
                </div>

                <form action="cart.php" method="POST">
                    <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">

                    <div class="quantity-container">
                        <label for="quantity">Jumlah: </label>
                        <input type="number" name="quantity" id="quantity" min="50" value="50">
                    </div>
                    <a href="cart.php">
                    <button type="submit" class="add-to-cart">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>

                <!-- Button Checkout -->
                <a href="checkout.php">
                    <button class="checkout-btn">
                        <i class="fas fa-shopping-cart"></i> Proceed to Checkout
                    </button>
                </a>
            </div>
        </div>
    </div>

</body>
</html>