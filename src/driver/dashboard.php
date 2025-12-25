<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'driver') {
    header("Location: ../auth/login.php");
    exit;
}
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>RideVista Driver</title>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>

<style>
*{ box-sizing:border-box; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto; }
body{ margin:0; background:#fff; }

/* NAV */
.nav{
    height:64px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 32px;
    border-bottom:1px solid #eee;
}
.logo{ font-size:22px; font-weight:700; }
.nav-right{ display:flex; align-items:center; gap:16px; }

/* TOGGLE */
.toggle{
    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
}
.toggle span{
    font-size:14px;
    font-weight:500;
}
.switch{
    width:42px;
    height:22px;
    background:#ccc;
    border-radius:22px;
    position:relative;
}
.switch::after{
    content:'';
    width:18px;
    height:18px;
    background:#fff;
    border-radius:50%;
    position:absolute;
    top:2px; left:2px;
    transition:.2s;
}
.switch.active{ background:#000; }
.switch.active::after{ left:22px; }

/* LAYOUT */
.main{ display:flex; height:calc(100vh - 64px); }

/* LEFT */
.left{
    width:380px;
    padding:24px;
    border-right:1px solid #eee;
}
.card{
    background:#f7f7f7;
    padding:20px;
    border-radius:16px;
    margin-bottom:16px;
}
.card h3{ margin-top:0; }

/* BUTTONS */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
}
.accept{ background:#000;color:#fff; }
.decline{ background:#eee;margin-top:8px; }
.complete{ background:#000;color:#fff; }

/* MAP */
.map{ flex:1; }
#map{ width:100%;height:100%; }

/* PROFILE */
.avatar{ width:34px;height:34px;background:#ddd;border-radius:50%;cursor:pointer; }
.profile{
    position:absolute;
    top:70px;right:32px;
    background:#fff;
    width:260px;
    padding:16px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
    display:none;
}
.profile.active{ display:block; }
.profile div{ padding:10px 0;border-top:1px solid #eee;cursor:pointer; }
.profile div:last-child{ color:red;text-align:center; }
</style>
</head>

<body>

<!-- NAV -->
<div class="nav">
    <div class="logo">RideVista Driver</div>

    <div class="nav-right">
        <div class="toggle" onclick="toggleOnline()">
            <span id="statusText">Offline</span>
            <div class="switch" id="switch"></div>
        </div>
        <div class="avatar" onclick="toggleProfile()"></div>
    </div>

    <div class="profile" id="profileMenu">
        <strong><?= htmlspecialchars($name) ?></strong>
        <div>Earnings</div>
        <div>Activity</div>
        <div onclick="location.href='../auth/logout.php'">Sign out</div>
    </div>
</div>

<div class="main">

<!-- LEFT PANEL -->
<div class="left">

<!-- OFFLINE -->
<div class="card" id="offlineCard">
    <h3>You’re offline</h3>
    <p>Go online to start receiving ride requests.</p>
</div>

<!-- WAITING -->
<div class="card" id="waitingCard" style="display:none;">
    <h3>Looking for rides…</h3>
    <p>Stay online to receive requests.</p>
</div>

<!-- INCOMING RIDE -->
<div class="card" id="requestCard" style="display:none;">
    <h3>New ride request</h3>
    <p><b>Pickup:</b> MG Road</p>
    <p><b>Drop:</b> Indiranagar</p>
    <p><b>Fare:</b> ₹180</p>
    <button class="btn accept">Accept</button>
    <button class="btn decline">Decline</button>
</div>

<!-- ACTIVE RIDE -->
<div class="card" id="activeRide" style="display:none;">
    <h3>On trip</h3>
    <p>Passenger picked up</p>
    <button class="btn complete">Complete ride</button>
</div>

</div>

<!-- MAP -->
<div class="map"><div id="map"></div></div>

</div>

<script>
function toggleOnline(){
    const sw=document.getElementById('switch');
    const text=document.getElementById('statusText');
    sw.classList.toggle('active');
    const online=sw.classList.contains('active');

    document.getElementById('offlineCard').style.display=online?'none':'block';
    document.getElementById('waitingCard').style.display=online?'block':'none';
    text.innerText=online?'Online':'Offline';
}
function toggleProfile(){
    document.getElementById('profileMenu').classList.toggle('active');
}
function initMap(){
    const center={lat:12.9716,lng:77.5946};
    const map=new google.maps.Map(document.getElementById("map"),{
        zoom:12,center:center,disableDefaultUI:true,zoomControl:true
    });
    new google.maps.Marker({position:center,map:map});
}
initMap();
</script>

</body>
</html>
