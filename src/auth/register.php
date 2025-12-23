<!DOCTYPE html>
<html>
<head>
    <title>Register | RideVista</title>
</head>
<body>

<h2>Create Account</h2>

<form method="POST" action="register_process.php">
    <input type="text" name="name" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <select name="role">
        <option value="user">Rider</option>
        <option value="driver">Driver</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
