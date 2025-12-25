<?php
function calculateFare($km, $vehicleId, $conn){
  $q = mysqli_query($conn,
    "SELECT rate_per_km FROM vehicle_types WHERE id=$vehicleId"
  );
  $rate = mysqli_fetch_assoc($q)['rate_per_km'];
  return $km * $rate;
}
