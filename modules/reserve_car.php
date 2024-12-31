<?php
include 'C:\xampp\htdocs\car-rental-system\config\db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure that the customer is logged in
    if (!isset($_SESSION['customer_id'])) {
        echo "Please log in to reserve a car.";
        exit;
    }

    $customer_id = $_SESSION['customer_id'];
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query to get the price per day for the selected car
    $sql = "SELECT price_per_day FROM cars WHERE id=$car_id AND status='active'";
    $car = $conn->query($sql)->fetch_assoc();

    if ($car) {
        // Check if the car is already reserved or rented during the selected period
        $sql_check_reservation = "SELECT * FROM reservations 
                                  WHERE car_id = $car_id 
                                  AND ((start_date BETWEEN '$start_date' AND '$end_date') 
                                  OR (end_date BETWEEN '$start_date' AND '$end_date') 
                                  OR ('$start_date' BETWEEN start_date AND end_date) 
                                  OR ('$end_date' BETWEEN start_date AND end_date))";

        $reservation_check = $conn->query($sql_check_reservation);

        if ($reservation_check->num_rows > 0) {
            echo "This car is already reserved or rented during the selected period.";
        } else {
            // Calculate the total price based on the duration of the reservation
            $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
            $total_price = $days * $car['price_per_day'];

            // Insert reservation into the database
            $sql_insert_reservation = "INSERT INTO reservations (customer_id, car_id, start_date, end_date, total_price) 
                                       VALUES ($customer_id, $car_id, '$start_date', '$end_date', $total_price)";

            if ($conn->query($sql_insert_reservation) === TRUE) {
                // Update the car's status to 'rented' after the reservation
                echo "Car reserved successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Car not available or invalid car ID.";
    }
}
?>

<form method="POST">
    <input type="number" name="car_id" placeholder="Car ID" required>
    <input type="date" name="start_date" required>
    <input type="date" name="end_date" required>
    <button type="submit">Reserve</button>
</form>
