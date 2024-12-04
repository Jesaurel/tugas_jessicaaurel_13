<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* General Styling */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #4a148c; /* Warna ungu tua */
      color: #fff;
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    header h1 {
      margin: 0;
      font-size: 24px;
    }

    .card-container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }


.card {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  margin: 10px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
  background-color: #fff;
  border: #fdd835;
  outline: 3px solid #fdd835; /* Permanent outline color */
}

.card:hover {
  transform: scale(1.05); /* Slight zoom effect on hover */
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Stronger shadow on hover */
}

    .card .icon img {
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
    }

    .card h4 {
      font-size: 18px;
      margin-bottom: 15px;
    }

    .card .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #4a148c; /* Warna ungu tua */
      color: #fff;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    .card .btn:hover {
      background: #ffeb3b; /* Warna emas */
    }

    /* Charts Container */
    .charts-container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* Make the charts responsive */
    canvas {
      width: 100% !important;
      height: auto !important;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Responsive for smaller screens */
    @media (max-width: 768px) {
      .charts-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h1>Admin Dashboard</h1>
  </header>

  <!-- CardView Section -->
  <div class="card-container">
    <div class="card">
      <div class="icon">
        <img src="assets/icons/orders-icon.png" alt="Manage Orders Icon">
      </div>
      <h4>Manage Orders</h4>
      <a href="manage_orders.php" class="btn">View</a>
    </div>
    <div class="card">
      <div class="icon">
        <img src="assets/icons/menu-icon.png" alt="Manage Menu Icon">
      </div>
      <h4>Manage Menu</h4>
      <a href="manage_menu.php" class="btn">View</a>
    </div>
    <div class="card">
      <div class="icon">
        <img src="assets/icons/categories-icon.png" alt="Manage Categories Icon">
      </div>
      <h4>Manage Categories</h4>
      <a href="manage_categories.php" class="btn">View</a>
    </div>
    <div class="card">
      <div class="icon">
        <img src="assets/icons/reports-icon.png" alt="View Reports Icon">
      </div>
      <h4>View Reports</h4>
      <a href="manage_reports.php" class="btn">View</a>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="charts-container">
    <canvas id="visitsChart"></canvas>
    <canvas id="ordersChart"></canvas>
  </div>

  <script>
    // Fetch visits data from MySQL (via PHP)
    async function fetchVisitsData() {
      const response = await fetch('get_visits_data.php');
      const data = await response.json();
      return data;
    }

    // Fetch orders data from MySQL (via PHP)
    async function fetchOrdersData() {
      const response = await fetch('get_orders_data.php');
      const data = await response.json();
      return data;
    }

    // Initialize charts with MySQL data
    async function initializeCharts() {
      const [visitsData, ordersData] = await Promise.all([fetchVisitsData(), fetchOrdersData()]);

      // Prepare the chart data for visits
      const visitsChartData = {
        labels: Object.keys(visitsData),
        datasets: [{
          label: 'Visits This Week',
          data: Object.values(visitsData),
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      };

      // Prepare the chart data for orders
      const ordersChartData = {
        labels: Object.keys(ordersData),
        datasets: [{
          label: 'Orders This Week',
          data: Object.values(ordersData),
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }]
      };

      // Create visits chart
      const visitsConfig = {
        type: 'line',
        data: visitsChartData,
        options: {
          responsive: true,
          plugins: {
            legend: { display: true }
          }
        }
      };

      // Create orders chart
      const ordersConfig = {
        type: 'line',
        data: ordersChartData,
        options: {
          responsive: true,
          plugins: {
            legend: { display: true }
          }
        }
      };

      // Initialize the charts
      new Chart(document.getElementById('visitsChart'), visitsConfig);
      new Chart(document.getElementById('ordersChart'), ordersConfig);
    }

    // Run the chart initialization
    initializeCharts();
  </script>

</body>
</html>
