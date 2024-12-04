<?php
$servername = "localhost"; // Or your database host
$username = "root"; // Your database username
$password = "Jess1_MySql!"; // Your database password
$dbname = "jessicaaurelclarista_13_catering"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM visits"; // Sesuaikan dengan query Anda
$result = $conn->query($sql);

$visitsData = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $visitsData[$row['date']] = $row['visit_count']; // Sesuaikan dengan kolom Anda
  }
}

echo json_encode($visitsData);

$conn->close();
?>