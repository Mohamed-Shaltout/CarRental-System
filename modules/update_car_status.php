<?php
include 'C:\xampp\htdocs\car-rental-system\config\db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_id = $_POST['car_id'];
    $status = $_POST['status'];

    $sql = "UPDATE cars SET status='$status' WHERE id=$car_id";

    if ($conn->query($sql) === TRUE) {
        echo "Car status updated.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="number" name="car_id" placeholder="Car ID" required>
    <select name="status">
        <option value="active">Active</option>
        <option value="out_of_service">Out of Service</option>
        <option value="rented">Rented</option>
    </select>
    <button type="submit">Update Status</button>
</form>
