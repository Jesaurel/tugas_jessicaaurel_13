<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "Jess1_MySql!", "jessicaaurelclarista_13_catering");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan kategori
$categories_result = $conn->query("SELECT * FROM categories");

// Query untuk mendapatkan menu
$where_clause = "1=1"; // Default tanpa filter
if (isset($_GET['category_id']) && $_GET['category_id'] !== 'all') {
    $category_id = intval($_GET['category_id']);
    $where_clause .= " AND category_id = $category_id";
}
if (isset($_GET['search'])) {
    $search_term = $conn->real_escape_string($_GET['search']);
    $where_clause .= " AND name LIKE '%$search_term%'";
}
$menu_result = $conn->query("SELECT * FROM menu WHERE $where_clause");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Lezat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #4c2a82;
            color: #fff;
            padding: 15px 0;
        }
        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }
        .header a:hover {
            color: #d4af37;
        }
        .menu-section {
            padding: 40px 20px;
        }
        .sidebar {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }
        .sidebar h5 {
            color: #4c2a82;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-color: #d4af37;
        }
        .footer {
            background-color: #4c2a82;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .btn-primary {
            background-color: #4c2a82;
            border: none;
        }
        .btn-primary:hover {
            background-color: #d4af37;
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    <?php include('../includes/header.php'); ?>
    <?php include('../contact.php'); ?>

    <!-- Content -->
    <div class="container menu-section">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5>Filter Menu</h5>
                    <form method="GET" action="">
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" id="search" name="search" class="form-control" placeholder="Search menu...">
                        </div>
                        <div class="mb-3">
                            <label for="categories" class="form-label">Categories</label>
                            <select id="categories" name="category_id" class="form-select">
                                <option value="all">All</option>
                                <?php while ($category = $categories_result->fetch_assoc()): ?>
                                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </form>
                </div>
            </div>

            <!-- Menu Items -->
<div class="col-md-9">
    <div class="row">
        <?php if ($menu_result->num_rows > 0): ?>
            <?php while ($menu = $menu_result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Tambahkan tautan pada gambar -->
                        <a href="menu-detail.php?id=<?= $menu['id']; ?>">
                            <img src="https://drive.google.com/uc?export=view&id=<?= $menu['image']; ?>" class="card-img-top" alt="<?= htmlspecialchars($menu['name']); ?>">
                        </a>
                        <div class="card-body text-center">
                            <!-- Nama Menu menjadi tautan -->
                            <a href="menu-detail.php?id=<?= $menu['id']; ?>" style="text-decoration: none; color: inherit;">
                                <h5 class="card-title"><?= htmlspecialchars($menu['name']); ?></h5>
                            </a>
                            <p class="card-text">Rp<?= number_format($menu['price'], 0, ',', '.'); ?></p>
                            <!-- Tombol menuju menu-detail -->
                            <a href="menu-detail.php?id=<?= $menu['id']; ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No menu items found.</p>
        <?php endif; ?>
    </div>
</div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>