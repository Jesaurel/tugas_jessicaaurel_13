<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT menus.* FROM favorites INNER JOIN menus ON favorites.menu_id = menus.id WHERE favorites.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$favorites = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Favorites</title>
    <link rel="stylesheet" href="../assets/css/favorites.css">
</head>
<body>
    <h1>Favorites</h1>
    <?php if (count($favorites) > 0): ?>
        <ul>
            <?php foreach ($favorites as $menu): ?>
                <li>
                    <strong><?= htmlspecialchars($menu['name']); ?></strong>
                    <p><?= htmlspecialchars($menu['description']); ?></p>
                    <p>Price: <?= $menu['price']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No favorites found.</p>
    <?php endif; ?>
</body>
</html>