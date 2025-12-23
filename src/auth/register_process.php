<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../config/db.php";

$name  = $_POST['name'];
$email = $_POST['email'];
$role  = $_POST['role'];

// 🔐 Password hashing (VERY IMPORTANT)
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if email already exists
$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    die("❌ Email already registered");
}

// Insert user
$query = "INSERT INTO users (name, email, password, role)
          VALUES ('$name', '$email', '$password', '$role')";

if (mysqli_query($conn, $query)) {
    echo "✅ Registration successful";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>
