<?php
// manage_reports.php
session_start();

// Include database connection
require_once '../config/config.php';
require_once '../config/db.php';

// Initialize variables for filtering
$start_date = $end_date = $category = '';
$filtered_reports = []; // Array for filtered report results

// Format Rupiah function
function formatRupiah($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

// Check if filter form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $category = $_POST['category'] ?? '';

    // Validate date inputs
    if (!empty($start_date) && !strtotime($start_date)) {
        echo "Invalid start date.";
        exit;
    }

    if (!empty($end_date) && !strtotime($end_date)) {
        echo "Invalid end date.";
        exit;
    }

    // Build query based on filters
    $query = "SELECT * FROM sales WHERE 1=1";
    
    if (!empty($start_date)) {
        $query .= " AND date >= ?";
    }
    if (!empty($end_date)) {
        $query .= " AND date <= ?";
    }
    if (!empty($category)) {
        $query .= " AND category = ?";
    }

    // Prepare the query
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    if (!empty($start_date) && !empty($end_date) && !empty($category)) {
        $stmt->bind_param("sss", $start_date, $end_date, $category);
    } elseif (!empty($start_date) && !empty($end_date)) {
        $stmt->bind_param("ss", $start_date, $end_date);
    } elseif (!empty($start_date)) {
        $stmt->bind_param("s", $start_date);
    } elseif (!empty($category)) {
        $stmt->bind_param("s", $category);
    }

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        $filtered_reports = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Log error and show user-friendly message
        error_log("SQL Error: " . $conn->error);
        echo "<p>An error occurred while fetching the data. Please try again later.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reports</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Body and Main Section */
        body {
            background-color: #fafafa;
            color: #333;
            padding: 20px;
        }

        /* Header */
        header {
            background-color: #f5a623; /* Soft orange for warmth */
            padding: 20px;
            color: #fff;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        /* Navigation */
        nav a {
            text-decoration: none;
            color: #fff;
            margin: 0 10px;
            font-size: 1rem;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Report Section */
        .report-options {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .report-options h2 {
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 15px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        form label {
            font-weight: 600;
            color: #444;
        }

        form input, form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
        }

        form button {
            grid-column: span 2;
            padding: 10px;
            background-color: #f5a623; /* Match header color */
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }

        form button:hover {
            background-color: #d4881f; /* Slightly darker on hover */
        }

        /* Table */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f5a623;
            color: #fff;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table td {
            color: #333;
        }

        /* Download Button */
        .cta-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a148c; /* Soft purple */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            margin-top: 20px;
        }

        .cta-btn:hover {
            background-color: #3c0a6b; /* Darker purple */
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Reports</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section class="report-options">
            <h2>Download Report</h2>
            <!-- Filter Form -->
            <form action="manage_reports.php" method="POST">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date); ?>">

                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date); ?>">

                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="">All</option>
                    <option value="food" <?= $category == 'food' ? 'selected' : ''; ?>>Food</option>
                    <option value="beverages" <?= $category == 'beverages' ? 'selected' : ''; ?>>Beverages</option>
                    <!-- Add more categories as needed -->
                </select>

                <button type="submit" class="cta-btn">Filter Reports</button>
            </form>

            <h3>Filtered Reports</h3>
            <!-- Display Filtered Results -->
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Customer</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($filtered_reports)) : ?>
                        <?php foreach ($filtered_reports as $index => $report) : ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= htmlspecialchars($report['date']); ?></td>
                                <td><?= htmlspecialchars($report['category']); ?></td>
                                <td><?= htmlspecialchars($report['customer']); ?></td>
                                <td><?= formatRupiah($report['amount']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h3>Download Report</h3>
            <!-- Download Report Link -->
            <a href="download_reports.php?start_date=<?= urlencode($start_date); ?>&end_date=<?= urlencode($end_date); ?>&category=<?= urlencode($category); ?>" class="cta-btn">Download Filtered Sales Report</a>
        </section>
    </main>
</body>
</html>