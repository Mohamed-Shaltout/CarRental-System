<?php
include 'C:\xampp\htdocs\car-rental-system\config\db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_info = $_POST['car_info'];
    $customer_info = $_POST['customer_info'];
    $reservation_date = $_POST['reservation_date'];


    $query = "SELECT 
                r.id AS reservation_id,
                c.name AS customer_name,
                c.email AS customer_email,
                c.phone AS customer_phone,
                car.model AS car_model,
                car.plate_id AS car_plate_id,
                car.status AS car_status,
                r.start_date,
                r.end_date,
                r.total_price,
                r.status AS reservation_status
            FROM 
                reservations r
            JOIN customers c ON r.customer_id = c.id
            JOIN cars car ON r.car_id = car.id
            WHERE 1=1";

    // Add conditions for the car information
    if (!empty($car_info)) {
        $query .= " AND (car.model LIKE '%$car_info%' OR car.plate_id LIKE '%$car_info%' OR car.status LIKE '%$car_info%')";
    }

    // Add conditions for the customer information
    if (!empty($customer_info)) {
        $query .= " AND (c.name LIKE '%$customer_info%' OR c.email LIKE '%$customer_info%' OR c.phone LIKE '%$customer_info%')";
    }

    // Add conditions for the reservation date
    if (!empty($reservation_date)) {
        $query .= " AND ('$reservation_date' BETWEEN r.start_date AND r.end_date)";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Reservation ID</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone</th>
                    <th>Car Model</th>
                    <th>Car Plate ID</th>
                    <th>Car Status</th>
                    <th>Reservation Start</th>
                    <th>Reservation End</th>
                    <th>Total Price</th>
                    <th>Reservation Status</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['reservation_id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['customer_email']}</td>
                    <td>{$row['customer_phone']}</td>
                    <td>{$row['car_model']}</td>
                    <td>{$row['car_plate_id']}</td>
                    <td>{$row['car_status']}</td>
                    <td>{$row['start_date']}</td>
                    <td>{$row['end_date']}</td>
                    <td>{$row['total_price']}</td>
                    <td>{$row['reservation_status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No results found for the given criteria.";
    }
}
?>

<form method="POST">
    <label>Car Information:</label>
    <input type="text" name="car_info" placeholder="Model, Plate ID, or Status">
    <br>
    <label>Customer Information:</label>
    <input type="text" name="customer_info" placeholder="Name, Email, or Phone">
    <br>
    <label>Reservation Date:</label>
    <input type="date" name="reservation_date">
    <br>
    <button type="submit">Search</button>
</form>
