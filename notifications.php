<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="../assets/css/notifications.css">
</head>
<body>
    <h1>Notifications</h1>
    <?php if (count($notifications) > 0): ?>
        <ul>
            <?php foreach ($notifications as $notification): ?>
                <li>
                    <strong><?= htmlspecialchars($notification['title']); ?></strong>
                    <p><?= htmlspecialchars($notification['message']); ?></p>
                    <p><?= date("d M Y, H:i", strtotime($notification['created_at'])); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No notifications found.</p>
    <?php endif; ?>
</body>
</html>