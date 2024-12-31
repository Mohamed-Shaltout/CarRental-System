<?php
// Include the database connection
include '../config/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Access denied. Please log in.";
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $specific_date = $_POST['specific_date'];

    // Query to get the status of all cars on a specific day
    $sql = "SELECT c.id AS car_id, c.model, c.year, c.plate_id, c.status,
                   CASE 
                       WHEN r.start_date <= ? AND r.end_date >= ? THEN 'rented'
                       ELSE c.status
                   END AS effective_status
            FROM cars c
            LEFT JOIN reservations r ON c.id = r.car_id AND r.start_date <= ? AND r.end_date >= ?
            GROUP BY c.id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $specific_date, $specific_date, $specific_date, $specific_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Car Status on $specific_date</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Car ID</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Plate ID</th>
                    <th>Status</th>
                </tr>";

        // Display results in a table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['car_id'] . "</td>
                    <td>" . $row['model'] . "</td>
                    <td>" . $row['year'] . "</td>
                    <td>" . $row['plate_id'] . "</td>
                    <td>" . $row['effective_status'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No cars found for the specified day.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Status</title>
</head>
<body>
    <h1>Car Status Report</h1>
    <form method="POST">
        <label for="specific_date">Select Date:</label>
        <input type="date" name="specific_date" required>
        <br><br>
        <button type="submit">Get Status</button>
    </form>
</body>
</html>
