<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'rider') {
    header("Location: ../auth/login.php");
    exit;
}
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>RideVista – Rider</title>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>

<style>
*{
    box-sizing:border-box;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto;
}
body{
    margin:0;
    background:#fff;
}

/* NAVBAR */
.nav{
    height:64px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 32px;
    border-bottom:1px solid #eee;
}
.logo{
    font-size:22px;
    font-weight:700;
}
.tabs span{
    margin-left:24px;
    cursor:pointer;
    font-weight:500;
    padding-bottom:6px;
}
.tabs .active{
    border-bottom:3px solid #000;
}
.nav-right{
    display:flex;
    align-items:center;
    gap:16px;
}

/* LAYOUT */
.main{
    display:flex;
    height:calc(100vh - 64px);
}

/* LEFT PANEL */
.left{
    width:400px;
    padding:24px;
    border-right:1px solid #eee;
}
.card{
    background:#f7f7f7;
    padding:20px;
    border-radius:16px;
}
.card h3{
    margin-top:0;
}

/* INPUTS */
.input{
    background:#fff;
    border:1px solid #ddd;
    padding:14px;
    border-radius:10px;
    margin-bottom:12px;
}
.input input, .input select{
    width:100%;
    border:none;
    font-size:14px;
}
.input input:focus{
    outline:none;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    background:#000;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
}

/* MAP */
.map{
    flex:1;
}
#map{
    width:100%;
    height:100%;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="nav">
    <div style="display:flex;align-items:center;">
        <div class="logo">RideVista</div>
        <div class="tabs" style="margin-left:40px;">
            <span class="active">Ride</span>
            <span>Courier</span>
            <span>Rentals</span>
        </div>
    </div>
    <div class="nav-right">
        <span>Activity</span>
        <span><?= htmlspecialchars($name) ?></span>
    </div>
</div>

<div class="main">

<!-- LEFT PANEL -->
<div class="left">
    <div class="card">
        <h3>Get a ride</h3>

        <div class="input">
            <input id="pickup" placeholder="Pickup location">
        </div>

        <div class="input">
            <input id="drop" placeholder="Dropoff location">
        </div>

        <div class="input">
            <select>
                <option>Pickup now</option>
                <option>Schedule later</option>
            </select>
        </div>

        <div class="input">
            <select>
                <option>For me</option>
                <option>For someone else</option>
            </select>
        </div>

        <button onclick="searchRide()">Search</button>
    </div>
</div>

<!-- MAP -->
<div class="map">
    <div id="map"></div>
</div>

</div>

<script>
let map;
let directionsService;
let directionsRenderer;

function initMap(){
    const center = { lat:12.9716, lng:77.5946 }; // Bangalore

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: center,
        disableDefaultUI: true,
        zoomControl: true
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
        map: map
    });
}

// SEARCH BUTTON LOGIC
function searchRide(){
    const pickup = document.getElementById("pickup").value.trim();
    const drop = document.getElementById("drop").value.trim();

    if (!pickup || !drop){
        alert("Please enter pickup and drop locations");
        return;
    }

    directionsService.route({
        origin: pickup,
        destination: drop,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(result, status){
        if (status === "OK"){
            directionsRenderer.setDirections(result);
            alert("Finding drivers nearby…");
        } else {
            alert("Unable to calculate route");
        }
    });
}

window.onload = initMap;
</script>

</body>
</html>
