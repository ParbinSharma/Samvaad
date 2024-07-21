<?php
session_start();
require('db_connect.php');
$pdnm=false;
$exists=false;
$sww=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {



  $name =mysqli_real_escape_string($conn,$_POST["name"]) ;
  $username = mysqli_real_escape_string($conn,$_POST["username"]);
  $password = mysqli_real_connect($conn,$_POST["password"]);
  $email = mysqli_real_escape_string($conn,$_POST["email"]);
  $c_password =mysqli_real_escape_string($conn,$_POST["confirm_password"]);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $check_sql = "SELECT * FROM `Accounts` WHERE `Username`='$username'";
  $check = mysqli_query($conn, $check_sql);
  $rows = mysqli_num_rows($check);
  if ($rows > 0) {
    $exists=true;
  } else {
    if ($password == $c_password) {

      $sql = "INSERT INTO `Accounts` (`Name`, `Username`, `Password`,`Date`,`Email`,`Description`,`Dob`) VALUES ('$name', '$username', '$hashed_password',current_timestamp(),'$email','Hey I am using Samvaad','00/00/000');";
      $insert = mysqli_query($conn, $sql);
      $date=getdate();
      $year = $date['year'];
      $activity_sql="INSERT INTO `ActivityChart` (`Id`,`Username`,`Year`,`Jan`,`Feb`,`Mar`,`Apr`,`May`,`Jun`,`Jul`,`Aug`,`Sept`,`Oct`,`Nov`,`Decem`) VALUES (NULL,'$username','$year',0,0,0,0,0,0,0,0,0,0,0,0)";
      $activity = mysqli_query($conn, $activity_sql);
      
      $join_samvaad_sql = "INSERT INTO `Room_members` (`Members`, `Room_Code`) VALUES ('$username', 'Samvaad')";
      $join_samvaad = mysqli_query($conn, $join_samvaad_sql);

      if ($insert) {
        header('location:Login.php');
      } else {
        $sww=true;
      //  echo mysqli_error($conn);
      }
    } else {
      $pdnm=true;
      
    }
    
    
    
  }
















}

?>
<html>
<head>
  <meta name="theme-color" content="#001C30" />
  <meta name="viewport" content="width=1024"/>
   <title>Samvaad • Signup</title>
<link rel="stylesheet" href="Style.css" type="text/css" media="all" />
 <link rel="icon" type="image/x-icon" href="/Media/S2.png"/>
<head>
<body>
  <div class="loader" id="loader">
<img src="Media/loader.gif" alt="" />
</div>
<div class="contents" id="contents">
<nav>
<div class="logo-div">
<img class="logo" src="Media/S2.png" alt="" />
</div>

<div class="nav-options">
<button onclick="window.location.href ='https://github.com/ParbinSharma'">Developer</button>
<button onclick="window.location.href='index.html';" type="submit">Info</button>
<button onclick="window.location.href='Settings.php';" type="submit">Contact</button>
</div>

<div class="register-login">
<button class="log-btn" onclick="window.location.href='Login.php';" type="submit">Login</button>
<button class="reg-btn" onclick="window.location.href='Signup.php';" type="submit">Register</button>
</div>
</nav>
<div class="cover">
<video autoplay="true" muted="true" loop id="vedioElement">
<source src="/Media/login_banner.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
</div>



<div class="container">
<img class="display-logo horizontal" src="Media/S2.png" alt="" />
<h1>Register</h1>
<?php 
if ($pdnm) {
  echo "<div class='banner'>
 <span> Passwords did not match</span>
  <span style='background-color:red' class='progress'></span>
  </div>
  ";
}
if ($sww) {
  echo "<div class='banner'>
 <span>Something went wrong.Please try after sometime.</span>
  <span style='background-color:red' class='progress'></span>
  </div>
  ";
}
if ($exists) {
  echo "<div class='banner'>
 <span>The Username already exists.</span>
  <span class='progress'></span>
  </div>
  ";
}
?>
<form class="form" action="Signup.php" method="POST">
<input class="credentials" type="text" name="name" id="name" placeholder="Full Name" required />
<input class="credentials" type="text" name="username" id="username" placeholder="Username" required />
<input class="credentials" type="email" name="email" id="email" placeholder="Email Address" required />
<input class="credentials" type="text" name="password" id="password" placeholder="Password" required />
<input class="credentials" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />



<input class="submit" type="submit" name="submit" id="submit" Value="Register" />
</form>

</div>
</div>
</body>
<script>
  document.onreadystatechange = function () {
if (document.readyState !== "complete") {
document.querySelector("#contents").style.visibility = "hidden";

document.querySelector("#loader").style.visibility = "visible";
} else {
document.querySelector(
"#loader").style.display = "none";
document.querySelector("#contents").style.visibility = "visible";
}
};
</script>
</html>