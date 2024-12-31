<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $year = $_POST['year'];
    $plate_id = $_POST['plate_id'];
    $office_location = $_POST['office_location'];
    $max_price = $_POST['max_price'];

    $query = "SELECT * FROM cars WHERE status = 'active'";

    // Add conditions based on user input
    if (!empty($model)) {
        $query .= " AND model LIKE '%$model%'";
    }
    if (!empty($year)) {
        $query .= " AND year = $year";
    }
    if (!empty($plate_id)) {
        $query .= " AND plate_id LIKE '$plate_id'";
    }
    if (!empty($office_location)) {
        $query .= " AND office_location LIKE '%$office_location%'";
    }
    if (!empty($max_price)) {
        $query .= " AND price_per_day <= $max_price";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Plate ID</th>
                    <th>Office Location</th>
                    <th>Price Per Day</th>
                    <th>Status</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['year']}</td>
                    <td>{$row['plate_id']}</td>
                    <td>{$row['office_location']}</td>
                    <td>{$row['price_per_day']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No available cars match your criteria.";
    }
}
?>

<form method="POST">
    <label>Model:</label>
    <input type="text" name="model" placeholder="Enter car model">
    <br>
    <label>Year:</label>
    <input type="number" name="year" placeholder="Enter car year">
    <br>
    <label>Plate ID:</label>
    <input type="text" name="plate_id" placeholder="Enter plate ID">
    <br>
    <label>Office Location:</label>
    <input type="text" name="office_location" placeholder="Enter office location">
    <br>
    <label>Max Price Per Day:</label>
    <input type="number" name="max_price" placeholder="Enter maximum price per day">
    <br>
    <button type="submit">Search</button>
</form>
