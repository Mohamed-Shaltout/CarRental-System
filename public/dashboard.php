<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
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
            <li><a href="../modules/reserve_car.php">Reserve a Car</a></li>
            <li><a href="../modules/search_cars.php">Search for Cars</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
