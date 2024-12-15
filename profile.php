<?php
session_start();
include '../includes/header.php'; // Include header file
require_once '../config/db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $update_query = "UPDATE users SET email = ?, address = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $email, $address, $password, $user_id);
    $stmt->execute();

    header("Location: profile.php?status=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <h1>Profile</h1>
    <form action="profile.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        <label>Address:</label>
        <input type="text" name="address" value="<?= htmlspecialchars($user['address']); ?>" required>
        <label>New Password:</label>
        <input type="password" name="password" placeholder="Leave blank to keep current">
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>