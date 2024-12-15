<?php
session_start();
include('../config/db.php');  // Pastikan koneksi database sudah benar

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$menu_id = $_POST['menu_id'];  // ID menu yang ditambahkan ke keranjang
$quantity = 1;  // Default quantity, bisa ditambah sesuai dengan form

// Cek apakah item sudah ada di keranjang
$sql = "SELECT * FROM cart WHERE user_id = ? AND menu_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $user_id, $menu_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Jika item sudah ada, update quantity
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND menu_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $menu_id);
    mysqli_stmt_execute($stmt);
} else {
    // Jika item belum ada, masukkan ke keranjang
    $sql = "INSERT INTO cart (user_id, menu_id, quantity) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iii', $user_id, $menu_id, $quantity);
    mysqli_stmt_execute($stmt);
}

header("Location: cart.php");  // Redirect ke halaman keranjang
exit();
?>