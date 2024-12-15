<?php
session_start();
include '../includes/header.php'; // Include header file
include '../config/db.php';

// Check if the cart exists, if not, initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add the menu to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['menu_id']) && isset($_POST['quantity'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // Check if the item already exists in the cart
    $item_found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $menu_id) {
            $item['quantity'] += $quantity;
            $item_found = true;
            break;
        }
    }

    // If the item doesn't exist, add a new entry to the cart
    if (!$item_found) {
        $query = "SELECT * FROM menu WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $menu = $result->fetch_assoc();

        // Add the item to the cart
        $_SESSION['cart'][] = [
            'id' => $menu['id'],
            'name' => $menu['name'],
            'price' => $menu['price'],
            'quantity' => $quantity,
            'image_url' => $menu['image_url']
        ];
    }
}

// Remove an item from the cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    // Re-index the array after removing the item
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.7/lottie.min.js"></script>
    <style>
        /* General styling */
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
        .cart-item {
            display: flex;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .cart-item img {
            max-width: 120px;
            border-radius: 10px;
            margin-right: 20px;
        }
        .cart-item .details {
            flex: 1;
        }
        .cart-item .details h3 {
            font-size: 1.5rem;
            margin: 0;
        }
        .cart-item .details p {
            font-size: 1rem;
            color: #555;
        }
        .cart-item .quantity {
            margin-top: 10px;
        }
        .delete-btn {
            color: red;
            cursor: pointer;
            font-size: 1.5rem;
            margin-top: 10px;
        }
        .delete-btn:hover {
            color: darkred;
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
            width: 100%;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }

        /* Style for the confirmation dialog */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
            position: relative;
        }
        .modal-content .modal-header,
        .modal-content .modal-footer {
            display: flex;
            justify-content: space-between;
        }
        .modal-content button {
            padding: 10px 20px;
            cursor: pointer;
        }
        .modal-content .cancel-btn {
            background-color: #ccc;
        }
        .modal-content .confirm-btn {
            background-color: #ff0000;
            color: white;
        }

        /* Style for the Lottie animation container */
        .lottie-container {
            width: 80px;
            height: 80px;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Your Cart</h2>
        
        <?php if (count($_SESSION['cart']) > 0): ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="cart-item">
                    <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                    <div class="details">
                        <h3><?php echo $item['name']; ?></h3>
                        <p>Price: Rp <?php echo number_format($item['price'], 2, ',', '.'); ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                    </div>
                    <!-- Trash Icon to delete item -->
                    <a href="#" class="delete-btn" onclick="confirmDelete(<?php echo $item['id']; ?>)">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            <?php endforeach; ?>
            
            <a href="checkout.php">
                <button class="checkout-btn">
                    <i class="fas fa-shopping-cart"></i> Proceed to Checkout
                </button>
            </a>
        
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Confirmation Dialog -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Are you sure you want to delete this item?</h3>
                <span onclick="closeModal()" style="font-size: 30px; cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Lottie Animation Container -->
                <div class="lottie-container" id="thinkingAnimation"></div>
            </div>
            <div class="modal-footer">
                <button class="cancel-btn" onclick="closeModal()">Cancel</button>
                <a id="confirmDeleteBtn" href="#" class="confirm-btn">
                    <button>Delete</button>
                </a>
            </div>
        </div>
    </div>

    <script>
        let currentItemId = null;

        // Function to open the confirmation modal
        function confirmDelete(itemId) {
            currentItemId = itemId;
            document.getElementById("confirmModal").style.display = "block";
            document.getElementById("confirmDeleteBtn").href = "cart.php?remove=" + itemId;

            // Load Lottie animation for "thinking"
            var animation = lottie.loadAnimation({
                container: document.getElementById('thinkingAnimation'), // The container for the animation
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'https://assets8.lottiefiles.com/packages/lf20_novm9hdy.json' // Path to the Lottie JSON animation
            });
        }

        // Function to close the confirmation modal
        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        // Close modal if clicked outside
        window.onclick = function(event) {
            if (event.target == document.getElementById("confirmModal")) {
                closeModal();
            }
        }
    </script>

</body>
</html>