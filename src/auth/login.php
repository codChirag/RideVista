<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

$error = "";
$mode = $_GET['mode'] ?? 'login';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($_POST['action'] === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if ($u = mysqli_fetch_assoc($q)) {
            if (password_verify($password, $u['password'])) {
                $_SESSION['id']   = $u['id'];
                $_SESSION['role'] = $u['role'];
                $_SESSION['name'] = $u['name'];

                if ($u['role'] === 'admin')  header("Location: ../admin/dashboard.php");
                if ($u['role'] === 'driver') header("Location: ../driver/dashboard.php");
                if ($u['role'] === 'rider')  header("Location: ../rider/dashboard.php");
                exit;
            }
        }
        $error = "Invalid email or password";
    }

    if ($_POST['action'] === 'register') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        mysqli_query($conn,
            "INSERT INTO users (name,email,password,role)
             VALUES ('$name','$email','$pass','$role')"
        );

        if ($role === 'driver') {
            $uid = mysqli_insert_id($conn);
            mysqli_query($conn,
                "INSERT INTO drivers (user_id,status) VALUES ($uid,'offline')"
            );
        }

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>RideVista – Go anywhere</title>

<style>
*{
    box-sizing:border-box;
    font-family: UberMove, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto;
}
body{
    margin:0;
    background:#fff;
    color:#000;
}

/* NAVBAR */
.nav{
    height:64px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 40px;
    border-bottom:1px solid #eee;
}
.nav .logo{
    font-size:22px;
    font-weight:700;
}
.nav .links a{
    margin-left:20px;
    text-decoration:none;
    color:#000;
    font-size:14px;
    font-weight:500;
}

/* LAYOUT */
.wrapper{
    display:flex;
    min-height:calc(100vh - 64px);
}
.left{
    flex:1;
    padding:80px 80px;
}
.right{
    flex:1;
    background:#f6f6f6;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* CONTENT */
h1{
    font-size:42px;
    margin-bottom:24px;
}
form{
    max-width:360px;
}
label{
    font-size:13px;
    font-weight:500;
}
input, select{
    width:100%;
    padding:14px;
    margin-top:6px;
    margin-bottom:16px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
}
button{
    width:100%;
    padding:14px;
    background:#000;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
}
.switch{
    margin-top:16px;
    font-size:14px;
}
.switch a{
    color:#000;
    text-decoration:underline;
}
.error{
    background:#ffe4e6;
    color:#b91c1c;
    padding:12px;
    border-radius:8px;
    margin-bottom:16px;
    font-size:14px;
}

/* IMAGE */
.right img{
    width:80%;
    max-width:420px;
}
</style>
</head>

<body>

<div class="nav">
    <div class="logo">RideVista</div>
    <div class="links">
        <a href="#">Ride</a>
        <a href="#">Drive</a>
        <a href="#">Business</a>
        <a href="?mode=login">Login</a>
        <a href="?mode=register">Sign up</a>
    </div>
</div>

<div class="wrapper">

<div class="left">
    <h1>Go anywhere with RideVista</h1>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($mode === 'login'): ?>

    <form method="POST">
        <input type="hidden" name="action" value="login">

        <label>Email</label>
        <input name="email" type="email" required>

        <label>Password</label>
        <input name="password" type="password" required>

        <button>Login</button>
    </form>

    <div class="switch">
        New here? <a href="?mode=register">Create an account</a>
    </div>

    <?php else: ?>

    <form method="POST">
        <input type="hidden" name="action" value="register">

        <label>Full name</label>
        <input name="name" required>

        <label>Email</label>
        <input name="email" type="email" required>

        <label>Password</label>
        <input name="password" type="password" required>

        <label>Register as</label>
        <select name="role">
            <option value="rider">Rider</option>
            <option value="driver">Driver</option>
        </select>

        <button>Create account</button>
    </form>

    <div class="switch">
        Already have an account? <a href="login.php">Login</a>
    </div>

    <?php endif; ?>
</div>

<div class="right">
    <img src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=1200">
</div>

</div>

</body>
</html>
