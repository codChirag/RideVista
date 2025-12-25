<?php
session_start();
include "../config/db.php";
include "../core/fare.php";

$d=mysqli_fetch_assoc(mysqli_query($conn,
 "SELECT id FROM drivers WHERE status='online' LIMIT 1"
));

$fare=calculateFare($_POST['km'],$_POST['vehicle'],$conn);

mysqli_query($conn,
 "INSERT INTO rides
 (rider_id,driver_id,vehicle_id,pickup,drop_location,distance_km,fare,payment,status)
 VALUES(".$_SESSION['id'].",".$d['id'].",".$_POST['vehicle'].",
 '".$_POST['pickup']."','".$_POST['drop']."',".$_POST['km'].",
 $fare,'".$_POST['payment']."','ongoing')"
);

mysqli_query($conn,"UPDATE drivers SET status='on_ride' WHERE id=".$d['id']);
header("Location: dashboard.php");
