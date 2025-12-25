<?php
session_start();
require('db_connect.php');
$pdnm=false;
$exists=false;
$sww=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {



  $name_s =mysqli_real_escape_string($conn,$_POST["name"]);
  $username_s = mysqli_real_escape_string($conn,$_POST["username"]);
  $password_s = mysqli_real_escape_string($conn,$_POST["password"]);
  $email_s = mysqli_real_escape_string($conn,$_POST["email"]);
  $department_s = mysqli_real_escape_string($conn,$_POST["department"]);
  $year_s = mysqli_real_escape_string($conn,$_POST["year"]);
  $c_password_s =mysqli_real_escape_string($conn,$_POST["confirm_password"]);
  $hashed_password_s = password_hash($password_s, PASSWORD_DEFAULT);
  $check_sql = "SELECT * FROM `Student_acc` WHERE `Username`='$username_s'";
  $check = mysqli_query($conn, $check_sql);
  $rows = mysqli_num_rows($check);
  if ($rows > 0) {
    $exists=true;
  } else {
    if ($password_s == $c_password_s) {

      $sql = "INSERT INTO `Student_acc` (`Name`, `Username`, `Password`,`Off_email`,`Department`,`Year`) VALUES ('$name_s', '$username_s', '$hashed_password_s','$email_s','$department_s','$year_s');";
      $insert = mysqli_query($conn, $sql);
      // $date=getdate();
      // $year = $date['year'];
   //   $activity_sql="INSERT INTO `ActivityChart` (`Id`,`Username`,`Year`,`Jan`,`Feb`,`Mar`,`Apr`,`May`,`Jun`,`Jul`,`Aug`,`Sept`,`Oct`,`Nov`,`Decem`) VALUES (NULL,'$username','$year',0,0,0,0,0,0,0,0,0,0,0,0)";
   //   $activity = mysqli_query($conn, $activity_sql);
      
   $join_samvaad_sql = "INSERT INTO `Chat_members` (`member`, `Chat_id`) VALUES ('$username_s', 'Samvaad')";
   $join_BEE_sql = "INSERT INTO `Chat_members` (`member`, `Chat_id`) VALUES ('$username_s', 'BEE')";
   $join_PHYSICS_sql = "INSERT INTO `Chat_members` (`member`, `Chat_id`) VALUES ('$username_s', 'PHYSICS')";
   $join_MATHEMATICS_sql = "INSERT INTO `Chat_members` (`member`, `Chat_id`) VALUES ('$username_s', 'MATHEMATICS')";
     $join_samvaad = mysqli_query($conn, $join_samvaad_sql);
    $join_BEE = mysqli_query($conn, $join_BEE_sql);
     $join_PHYSICS = mysqli_query($conn, $join_PHYSICS_sql);
     $join_MATHEMATICS = mysqli_query($conn, $join_MATHEMATICS_sql);


      if ($insert) {
        // echo ('succesful');
        header('location:Login.php');
      } else {
        $sww=true;
        echo mysqli_error($conn);
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
 <link rel="icon" type="image/x-icon" href="Media/S2.png"/>
 <style>
  body{
    overflow:hidden;
  }
  option{
    color: black;
  }
 </style>
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
<source src="Media/login_banner.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
</div>


<div class="wrap2">
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
<form class="form" id="teacher_form" action="Signup.php" method="POST">
<input class="credentials" type="text" name="name" id="name" placeholder="Full Name" required />
<input class="credentials" type="text" name="username" id="username" placeholder="Username" required />
<input class="credentials" type="email" name="email" id="email" placeholder="Official Email Address" required />
<select class="credentials" id="department" name="department">
    <option value="  "> Department</option>
    <option value="CSE 1">CSE 1</option>
    <option value="CSE 2">CSE 2</option>
    <option value="CSE 3">CSE 3</option>
    <option value="AI/ML">AI/ML</option>
    <option value="IT">IT</option>
    <option value="ECE">ECE</option>
    <option value="EE">EE</option>
  </select>
<select class="credentials" id="year" name="year">
    <option value=" ">Year</option>
    <option value="1st Year">1st Year</option>
    <option value="2nd Year">2nd Year</option>
    <option value="3rd Year">3rd Year</option>
    <option value="4th Year">4th Year</option>
    
  </select>
<input class="credentials" type="text" name="password" id="password" placeholder="Password" required />
<input class="credentials" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />



<input class="submit" type="submit" name="submit" id="submit" Value="Register" />
</form>






</div>
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