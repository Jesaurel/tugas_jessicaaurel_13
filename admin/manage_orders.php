<?php
// manage_orders.php

session_start();


// Menyertakan file konfigurasi database
require_once '../config/db.php'; // Pastikan path ke db.php benar

// Fungsi untuk mengirim email notifikasi
function sendEmailNotification($to, $subject, $message) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: " . FROM_NAME . " <" . FROM_EMAIL . ">" . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Notification sent successfully!";
    } else {
        echo "Failed to send notification.";
    }
}

// Fungsi untuk memperbarui status pesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update status pesanan di database
    $update_query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();

    // Kirim email notifikasi kepada admin setelah status diperbarui
    $subject = "Order Status Updated";
    $message = "<h1>Order #$order_id has been updated to '$status'.</h1>";
    sendEmailNotification("admin@example.com", $subject, $message);  // Ganti dengan email admin

    // Redirect atau tampilkan pesan sukses
    header("Location: manage_orders.php?status=updated");
    exit;
}

// Ambil daftar pesanan dari database
$query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($query);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../assets/css/admin.css"> <!-- Ganti dengan path CSS yang sesuai -->
</head>
<body>
    <header>
        <h1>Manage Orders</h1>
        <nav>
            <!-- Tautan navigasi admin -->
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section class="order-list">
            <h2>Order List</h2>
            <?php if (count($orders) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']); ?></td>
                                <td><?= htmlspecialchars($order['customer_name']); ?></td>
                                <td>
                                    <form method="POST" action="manage_orders.php">
                                        <select name="status" required>
                                            <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Processing" <?= $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                            <option value="Completed" <?= $order['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                        </select>
                                        <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                        <button type="submit" name="update_order">Update</button>
                                    </form>
                                </td>
                                <td><a href="view_order.php?id=<?= $order['id']; ?>">View Details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>