<?php
// manage_categories.php

session_start();

// Menyertakan file konfigurasi database
require_once '../config/db.php'; // Pastikan path ke db.php benar

// Tambah kategori baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    // Query untuk menambahkan kategori baru
    $insert_query = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();

    // Redirect setelah penambahan
    header("Location: manage_categories.php?status=added");
    exit;
}

// Edit kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    // Query untuk memperbarui kategori
    $update_query = "UPDATE categories SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $category_name, $category_id);
    $stmt->execute();

    // Redirect setelah pembaruan
    header("Location: manage_categories.php?status=updated");
    exit;
}

// Hapus kategori
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];

    // Query untuk menghapus kategori
    $delete_query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    // Redirect setelah penghapusan
    header("Location: manage_categories.php?status=deleted");
    exit;
}

// Ambil daftar kategori dari database
$query = "SELECT * FROM categories ORDER BY name ASC";
$result = $conn->query($query);
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #F9CBB8; /* Soft peach color */
            color: #2C3E50; /* Darker text color */
            padding: 15px 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        header h1 {
            margin: 0;
        }

        nav a {
            color: #2C3E50;
            text-decoration: none;
            padding: 10px;
            margin: 0 10px;
        }

        nav a:hover {
            background-color: #D8A2B5; /* Soft pink */
            border-radius: 4px;
        }

        /* Main Content */
        main {
            padding: 20px;
        }

        .category-crud h2 {
            font-size: 24px;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form h3 {
            font-size: 20px;
            color: #333;
        }

        form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        form button {
            padding: 10px 20px;
            background-color: #F39C12; /* Warm yellow */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        form button:hover {
            background-color: #F1C40F; /* Lighter yellow */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        table th {
            background-color: #ecf0f1;
        }

        .edit-form input[type="text"] {
            width: 200px;
        }

        /* Button Styles */
        .delete-button {
            background-color: #e74c3c; /* Red background */
            color: white; /* White text */
            border: none; /* Remove border */
            padding: 8px 16px; /* Padding to size the button */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 14px; /* Font size */
            margin-left: 10px; /* Space between update and delete buttons */
        }

        .delete-button:hover {
            background-color: #c0392b; /* Darker red when hovered */
            transition: background-color 0.3s ease; /* Smooth transition effect */
        }

        /* Make sure buttons fit inside the table */
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        /* Form styling */
        .edit-form input[type="text"] {
            width: 200px; /* Limit the size of the input field */
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .edit-form button {
            background-color: #27ae60; /* Green background for update */
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .edit-form button:hover {
            background-color: #2ecc71; /* Lighter green on hover */
            transition: background-color 0.3s ease;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        /* Make the table responsive */
        @media (max-width: 768px) {
            table, form {
                width: 100%;
            }
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Manage Categories</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="category-crud">
            <h2>Category Management</h2>

            <!-- Form untuk menambahkan kategori baru -->
            <form method="POST" action="manage_categories.php">
                <h3>Add New Category</h3>
                <input type="text" name="category_name" placeholder="Category Name" required>
                <button type="submit" name="add_category">Add Category</button>
            </form>

            <!-- Daftar kategori dalam tabel -->
            <h3>Existing Categories</h3>
            <?php if (count($categories) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['name']); ?></td>
                                <td>
                                    <!-- Form untuk mengedit kategori -->
                                    <form method="POST" action="manage_categories.php" class="edit-form" style="display: inline-block;">
                                        <input type="hidden" name="category_id" value="<?= $category['id']; ?>">
                                        <input type="text" name="category_name" value="<?= $category['name']; ?>" required>
                                        <button type="submit" name="edit_category">Update</button>
                                    </form>
                                    <!-- Form untuk menghapus kategori -->
                                    <form method="GET" action="manage_categories.php" style="display: inline-block; margin-left: 10px;">
                                        <input type="hidden" name="delete" value="<?= $category['id']; ?>">
                                        <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No categories found.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>