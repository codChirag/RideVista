<?php
include "../config/db.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $p=password_hash($_POST['password'],PASSWORD_DEFAULT);
  mysqli_query($conn,
   "INSERT INTO users(name,email,password,role)
    VALUES('".$_POST['name']."','".$_POST['email']."','$p','".$_POST['role']."')"
  );
  if($_POST['role']=="driver"){
    $uid=mysqli_insert_id($conn);
    mysqli_query($conn,"INSERT INTO drivers(user_id) VALUES($uid)");
  }
  header("Location: login.php");
}
?>
<form method="POST">
<input name="name" required>
<input name="email" required>
<input name="password" required>
<select name="role">
<option value="rider">Rider</option>
<option value="driver">Driver</option>
</select>
<button>Register</button>
</form>
