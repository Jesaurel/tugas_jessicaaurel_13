<?php
session_start();
require_once '../config/db.php';  // Ensure that your database connection is correct

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";  // SQL query to fetch orders
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);  // Bind user ID to the prepared statement
$stmt->execute();
$result = $stmt->get_result();  // Execute the query and get the result
$orders = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all orders for the user
$stmt->close();  // Close the prepared statement

$conn->close();  // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        header {
            background-color: #ffaf42;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .order-history {
            margin: 20px;
        }

        .order-history ul {
            list-style: none;
            padding: 0;
        }

        .order-history .order-item {
            background-color: white;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order-history .order-item strong {
            font-size: 18px;
            color: #333;
        }

        .order-history .order-item p {
            margin: 5px 0;
        }

        .order-history .order-item p:last-child {
            font-weight: bold;
            color: #ff5722;
        }
    </style>
</head>
<body>
    <header>
        <h1>Order History</h1>
    </header>

    <div class="order-history">
        <?php if (count($orders) > 0): ?>
            <ul>
                <?php foreach ($orders as $order): ?>
                    <li class="order-item">
                        <strong>Order #<?= htmlspecialchars($order['id']); ?></strong>
                        <p>Total Price: Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></p>
                        <p>Date: <?= date("d M Y, H:i", strtotime($order['created_at'])); ?></p>
                        <p>Status: <?= htmlspecialchars($order['status']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

</body>
</html>