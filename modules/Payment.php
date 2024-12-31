<?php
// Include the database connection
include 'C:\xampp\htdocs\car-rental-system\config\db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Access denied. Please log in.";
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query to get daily payments within the specified period
    $sql = "SELECT DATE(start_date) AS payment_date, SUM(total_price) AS daily_total
            FROM reservations
            WHERE start_date BETWEEN ? AND ?
            GROUP BY DATE(start_date)
            ORDER BY payment_date ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Daily Payments from $start_date to $end_date</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Date</th>
                    <th>Total Payments</th>
                </tr>";

        // Display results in a table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['payment_date'] . "</td>
                    <td>$" . number_format($row['daily_total'], 2) . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No payments found for the specified period.";
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
    <title>Daily Payments</title>
</head>
<body>
    <h1>Daily Payments Report</h1>
    <form method="POST">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>
        <br>
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>
        <br><br>
        <button type="submit">Get Report</button>
    </form>
</body>
</html>
