<?php
session_start();
include "../config/db.php";

$payment = $_POST['payment'];

$driver = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT id FROM drivers WHERE user_id=".$_SESSION['id']
));

mysqli_query($conn,
 "UPDATE rides 
  SET status='completed', payment='$payment'
  WHERE driver_id=".$driver['id']." AND status='ongoing'"
);

mysqli_query($conn,
 "UPDATE drivers SET status='online' WHERE id=".$driver['id']
);
