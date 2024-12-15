<?php
session_start();
include '../config/db.php'; // Koneksi database
include '../includes/header.php'; // Include header file

// Cek apakah keranjang kosong
if (empty($_SESSION['cart'])) {
    header('Location: ../index.php');
    exit;
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
    echo "<script>alert('You must be logged in to proceed with checkout.'); window.location.href='../login.php';</script>";
    exit;
}

// Hitung total harga dari keranjang
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Fungsi untuk menghitung biaya pengantaran
function calculateDeliveryFee($distance) {
    $base_fee = 10000; // Biaya dasar
    $per_km_rate = 2000; // Biaya per kilometer
    return $base_fee + ($distance * $per_km_rate);
}

// Tangani konfirmasi pesanan (pembayaran dan alamat pengiriman)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method']) && isset($_POST['address']) && isset($_POST['distance'])) {
    $payment_method = $_POST['payment_method'];
    $address = $_POST['address'];
    $distance = $_POST['distance'];

    // Menghitung biaya pengantaran
    $delivery_fee = calculateDeliveryFee($distance);

    // Total harga setelah ditambah biaya pengantaran
    $totalPrice += $delivery_fee;

    // Asumsikan user sudah login
    $user_id = $_SESSION['user_id'];

    // Masukkan pesanan ke database untuk metode pembayaran Cash
    if ($payment_method == 'cash') {
        // Query SQL untuk memasukkan pesanan
        $query = "INSERT INTO orders (user_id, total_price, payment_method, status, delivery_address, distance, delivery_fee) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        $status = 'pending'; // Status awal pesanan


    }
    // Jika metode pembayaran Dana, arahkan ke halaman pembayaran Dana
    if ($payment_method == 'dana') {
        header('Location: dana-payment.php');
        exit;
    }
}
?>

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <a href="../index.php">Home</a> > <a href="menu.php">Menu</a> > <a href="cart.php">Cart</a> > Checkout
</div>

<!-- Checkout Form -->
<div class="checkout-container">
    <h2>Checkout</h2>

    <div class="order-summary">
        <h3>Order Summary</h3>
     
    
        <p><strong>Total Price: IDR <?php echo number_format($totalPrice, 2); ?></strong></p>
    </div>

    <form method="POST" action="checkout.php">
        <!-- Payment Method Selection -->
        <div class="form-group">
            <label for="payment_method">Select Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="cash">Cash</option>
                <option value="dana">Dana (E-Wallet)</option>
            </select>
        </div>

        <!-- Delivery Address -->
        <div class="form-group">
            <label for="address">Delivery Address:</label>
            <textarea id="address" name="address" rows="4" placeholder="Enter your delivery address" required></textarea>
        </div>

        <!-- Distance -->
        <div class="form-group">
            <label for="distance">Distance from restaurant (km):</label>
            <input type="number" id="distance" name="distance" min="0" step="0.1" placeholder="Enter distance in km" required>
        </div>

        <button type="submit" class="btn-submit">Confirm Order</button>
    </form>
</div>

<!-- Confirmation Dialog -->
<div id="confirmationModal" class="confirmation-modal" style="display: none;">
    <div class="confirmation-content">
        <div class="lottie-container">
            <lottie-player id="thankYouLottie" src="https://assets1.lottiefiles.com/packages/lf20_L5BgeD.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
        </div>
        <h2>Thank you for your order!</h2>
        <p>Your order has been placed successfully. Click "OK" to go back to the menu.</p>
        <a href="menu.php" class="btn-ok">OK</a>
    </div>
</div>

<!-- Include Footer -->
<?php include '../includes/footer.php'; ?>

<!-- CSS Styles -->
<style>
.checkout-container {
    width: 100%;
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
}

h2 {
    color: #2c3e50;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    color: #34495e;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.form-group textarea {
    resize: vertical;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    color: #ffffff;
    background: #3498db;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-submit:hover {
    background: #2980b9;
}

.order-summary {
    padding: 15px;
    background: #f7f7f7;
    border: 1px solid #e1e1e1;
    border-radius: 5px;
    margin-bottom: 20px;
}

.order-summary h3 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #2c3e50;
}

.order-summary p {
    margin: 0;
    font-size: 16px;
    color: #7f8c8d;
}

.confirmation-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.confirmation-content {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 90%;
    max-width: 400px;
}
</style>

<!-- Lottie Script -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>