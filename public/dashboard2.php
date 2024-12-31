<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: C:\xampp\htdocs\car-rental-system\modules\login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Car Rental System</h1>
    <nav>
        <ul>
            <li><a href="../modules/register_car.php">Register a Car</a></li>
            <li><a href="../modules/AdvancedSearch.php">AdvancedSearch for Cars</a></li>
            <li><a href="../modules/update_car_status.php">Update Car Status</a></li>
            <li><a href="../modules/Payment.php">Search Daily Period</a></li>
            <li><a href="../modules/car_status.php">Car status in a specific day</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
