<?php
// Include the database connection
include '../config/db.php';
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query for customers
    $sql_customer = "SELECT * FROM customers WHERE username = ?";
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param("s", $username);
    $stmt_customer->execute();
    $result_customer = $stmt_customer->get_result();

    // Check if customer exists
    if ($result_customer->num_rows > 0) {
        $user = $result_customer->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['id'];
            header('Location: ../public/dashboard.php');
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        // Query for system users
        $sql_user = "SELECT * FROM system_users WHERE username = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        // Check if system user exists
        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: ../public/dashboard2.php');
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
