<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<h2>Welcome Rider, <?php echo $_SESSION['name']; ?></h2>
<a href="../auth/logout.php">Logout</a>
