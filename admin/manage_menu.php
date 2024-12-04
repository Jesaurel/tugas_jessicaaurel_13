<?php
// manage_menu.php

session_start();

// Menyertakan file konfigurasi database
require_once '../config/db.php'; // Pastikan path ke db.php benar

// Tambah menu baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_menu'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = str_replace([ 'Rp', '.', ',' ], '', $_POST['price']);
    $image_url = $_POST['image_url'];

    // Query untuk menambahkan menu baru
    $insert_query = "INSERT INTO menu (name, description, price, image_url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssds", $name, $description, $price, $image_url); 
    $stmt->execute();

    // Redirect setelah penambahan
    header("Location: manage_menu.php?status=added");
    exit;
}

// Edit menu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_menu'])) {
    $menu_id = $_POST['menu_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = str_replace([ 'Rp', '.', ',' ], '', $_POST['price']); // Menghapus format

    // Query untuk memperbarui menu
    $update_query = "UPDATE menu SET name = ?, description = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdi", $name, $description, $price, $menu_id);
    $stmt->execute();

    // Redirect setelah pembaruan
    header("Location: manage_menu.php?status=updated");
    exit;
}

// Hapus menu
if (isset($_GET['delete'])) {
    $menu_id = $_GET['delete'];

    // Query untuk menghapus menu
    $delete_query = "DELETE FROM menu WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();

    // Redirect setelah penghapusan
    header("Location: manage_menu.php?status=deleted");
    exit;
}

// Ambil daftar menu dari database
$query = "SELECT * FROM menu ORDER BY name ASC";
$result = $conn->query($query);
$menu_items = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Menu</title>
    <style>
        /* admin.css */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #ff8c00;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        h1, h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        h3 {
            margin-top: 20px;
        }

        /* CSS untuk tombol */
button {
    background-color: #e07b00;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #4a148c; /* Soft purple */
}

/* Tombol Hapus (Delete) */
button.delete {
    background-color: #e74c3c; /* Merah */
}

button.delete:hover {
    background-color: #c0392b; /* Merah gelap saat hover */
}

/* Tombol Sekunder - Misalnya tombol 'Cancel' atau 'Reset' */
button.secondary {
    background-color: #95a5a6; /* Abu-abu */
}

button.secondary:hover {
    background-color: #7f8c8d; /* Abu-abu gelap saat hover */
}


        .menu-crud form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
            box-sizing: border-box;
        }

        .menu-crud input, .menu-crud textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        td img {
            max-width: 100px;
        }

        a {
            color: #ff8c00;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsiveness */
        @media (min-width: 768px) {
            .menu-crud form {
                max-width: 800px;
                margin: 0 auto;
            }
        }

        @media (max-width: 767px) {
            .menu-crud form {
                padding: 15px;
            }

            .menu-crud input, .menu-crud textarea, .menu-crud button {
                font-size: 14px;
            }
        }
    </style>
    <script>
        // Format harga ke format Rupiah
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        // Mengubah input harga menjadi format Rupiah
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('price').addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value, 'Rp ');
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>Manage Menu</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section class="menu-crud">
            <h2>Menu Management</h2>

            <!-- Form untuk menambah menu baru -->
            <form method="POST" action="manage_menu.php">
                <h3>Add New Menu</h3>
                <input type="text" name="name" placeholder="Menu Name" required>
                <textarea name="description" placeholder="Menu Description" required></textarea>
                <input type="text" id="price" name="price" placeholder="Price (e.g., 100000)" required>
                <input type="text" name="image_url" placeholder="Image URL (Google Drive Link)" required>
                <button type="submit" name="add_menu">Add Menu</button>
            </form>

            <!-- Daftar menu dalam tabel -->
            <h3>Existing Menu</h3>
            <?php if (count($menu_items) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menu_items as $menu_item): ?>
                            <tr>
                                <td><?= htmlspecialchars($menu_item['name']); ?></td>
                                <td><?= htmlspecialchars($menu_item['description']); ?></td>
                                <td>Rp <?= number_format($menu_item['price'], 0, ',', '.'); ?></td>
                                <td><img src="<?= $menu_item['image_url']; ?>" alt="Image" width="100"></td>
                                <td>
                                    <!-- Form untuk mengedit menu -->
                                    <form method="POST" action="manage_menu.php">
                                        <input type="hidden" name="menu_id" value="<?= $menu_item['id']; ?>">
                                        <input type="text" name="name" value="<?= $menu_item['name']; ?>" required>
                                        <textarea name="description" required><?= $menu_item['description']; ?></textarea>
                                        <input type="text" id="price" name="price" value="<?= number_format($menu_item['price'], 0, ',', '.'); ?>" required>
                                        <button type="submit" name="edit_menu">Update</button>
                                    </form>
                                    <!-- Link untuk menghapus menu -->
                                    <a href="manage_menu.php?delete=<?= $menu_item['id']; ?>" onclick="return confirm('Are you sure?')">
                                        <button class="delete">Delete</button>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No menu items found.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>