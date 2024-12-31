<?php
include 'C:\xampp\htdocs\car-rental-system\config\db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $year = $_POST['year'];
    $plate_id = $_POST['plate_id'];
    $office_location = $_POST['office_location'];
    $price_per_day = $_POST['price_per_day'];
    $status = 'active';

    $sql = "INSERT INTO cars (model, year, plate_id, office_location, price_per_day, status)
            VALUES ('$model', $year, '$plate_id', '$office_location', $price_per_day, '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Car registered successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="text" name="model" placeholder="Car Model" required>
    <input type="number" name="year" placeholder="Year" required>
    <input type="text" name="plate_id" placeholder="Plate ID" required>
    <input type="text" name="office_location" placeholder="Office Location" required>
    <input type="number" step="0.01" name="price_per_day" placeholder="Price per Day" required>
    <button type="submit">Register Car</button>
</form>
