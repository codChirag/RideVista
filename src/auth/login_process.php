<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/db.php";

$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

    // Verify hashed password
    if (password_verify($password, $user['password'])) {

        // Store session values
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];

        // Role-based redirect
        if ($user['role'] == 'admin') {
            header("Location: ../admin/admin_dashboard.php");
        } elseif ($user['role'] == 'driver') {
            header("Location: ../driver/driver_dashboard.php");
        } else {
            header("Location: ../user/user_dashboard.php");
        }

        exit;

    } else {
        echo "❌ Invalid password";
    }

} else {
    echo "❌ User not found";
}
?>
