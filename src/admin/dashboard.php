<?php
session_start();
include "../config/db.php";
$r=mysqli_query($conn,
 "SELECT r.*,u.name FROM rides r JOIN users u ON r.rider_id=u.id"
);
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_REAL_API_KEY"></script>
<style>
body{background:#000;color:#fff;font-family:Segoe UI}
table{width:100%;border-collapse:collapse}
td,th{padding:12px;border-bottom:1px solid #222}
</style>
</head>
<body>

<h2>Admin</h2>
<div id="map" style="height:300px"></div>

<table>
<tr><th>User</th><th>Fare</th><th>Payment</th><th>Status</th></tr>
<?php while($x=mysqli_fetch_assoc($r)): ?>
<tr>
<td><?=$x['name']?></td>
<td><?=$x['fare']?></td>
<td><?=$x['payment']?></td>
<td><?=$x['status']?></td>
</tr>
<?php endwhile; ?>
</table>

<script>
new google.maps.Map(document.getElementById("map"),{
 center:{lat:12.97,lng:77.59},zoom:12
});
</script>

</body>
</html>
