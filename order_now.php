<?php
session_start();
include '../config/db.php';

// Fetch the menu details (based on the menu ID)
$menu_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$menu = null;
if ($menu_id) {
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menu = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu | Catering Lezat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #ffaf42;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        .menu-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .menu-image img {
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .menu-info {
            text-align: center;
            margin-top: 20px;
        }
        .menu-info h1 {
            font-size: 24px;
            color: #333;
        }
        .menu-info p {
            margin: 10px 0;
            color: #555;
        }
        .menu-info .price {
            font-size: 20px;
            color: #ff5722;
            font-weight: bold;
        }
        .add-to-cart {
            margin-top: 20px;
            text-align: center;
        }
        .add-to-cart input[type="number"] {
            width: 60px;
            padding: 5px;
            text-align: center;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .add-to-cart button {
            background-color: #ffaf42;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .add-to-cart button:hover {
            background-color: #e69538;
        }
        .error-message {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Detail Menu</h1>
    </header>

    <div class="menu-detail">
        <?php if ($menu): ?>
            <div class="menu-image">
                <?php if (!empty($menu['image'])): ?>
                    <img src="assets/images/<?php echo htmlspecialchars($menu['image']); ?>" alt="<?php echo htmlspecialchars($menu['name']); ?>">
                <?php else: ?>
                    <img src="assets/images/default.jpg" alt="Default Image">
                <?php endif; ?>
            </div>
            <div class="menu-info">
                <h1><?php echo htmlspecialchars($menu['name']); ?></h1>
                <p><?php echo htmlspecialchars($menu['description']); ?></p>
                <p class="price">Rp <?php echo number_format($menu['price'], 0, ',', '.'); ?></p>
            </div>

            <!-- Show error message if quantity validation failed -->
            <?php if (isset($_GET['error']) && $_GET['error'] === 'quantity'): ?>
                <div class="error-message">
                    Jumlah pesanan harus minimal 50.
                </div>
            <?php endif; ?>

            <!-- Show error message if database error occurred -->
            <?php if (isset($_GET['error']) && $_GET['error'] === 'database'): ?>
                <div class="error-message">
                    Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.
                </div>
            <?php endif; ?>

            <div class="add-to-cart">
                <form action="order-process.php" method="POST">
                    <input type="hidden" name="menu_id" value="<?php echo htmlspecialchars($menu['id']); ?>">

                    <!-- Input jumlah pesanan -->
                    <input type="number" name="quantity" value="50" min="50" step="10" required>

                    <button type="submit" name="action" value="beli">Buy Now</button>
                    <button type="submit" name="action" value="keranjang">Add to Cart</button>
                </form>
            </div>
        <?php else: ?>
            <p>Menu tidak ditemukan.</p>
        <?php endif; ?>
    </div>

</body>
</html>