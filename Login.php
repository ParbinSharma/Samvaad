<?php
require('db_connect.php');

$anf=false;
$wpas=false;
$sww=false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username=mysqli_real_escape_string($conn,$_POST['username']);
  $password=mysqli_real_escape_string($conn,$_POST['password']);
  
  $login_sql="SELECT * FROM `Accounts` WHERE `Username`='$username'";
  $login=mysqli_query($conn,$login_sql);
  
  $row=mysqli_fetch_assoc($login);
  $check_sql="SELECT * FROM `Accounts` WHERE `Username`='$username'";
  $check=mysqli_query($conn,$check_sql);
  $num= mysqli_num_rows($check);
  if ($num==1) {
    if(password_verify($password,$row['Password'])){ 
      setcookie('Username', $username, time() + (86400 * 30), "/");
      setcookie('Name', $row['Name'], time() + (86400 * 30), "/");
      setcookie('Date', $row['Date'], time() + (86400 * 30), "/");
      setcookie('Dob', $row['Dob'], time() + (86400 * 30), "/");
      setcookie('Email', $row['Email'], time() + (86400 * 30), "/");
      setcookie('Description', $row['Description'], time() + (86400 * 30), "/");
      setcookie('loggedin',true, time() + (86400 * 30), "/");
    session_start();
    
   // $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['Username'];
        $_SESSION['name'] = $row['Name'];

        header("location: Profile.php");
        $loggedin=true;
  }
  else {
    $wpas=true;
  }
  }
  else{
    $anf=true;
  }
if (!$login) {
    $sww=true;
    $anf=false;
  }
if (!$check) {
    $sww=true;
    $anf=false;
    $wpas=false;
  }


}

  

?>
<html>
  <head>
    <meta name="theme-color" content="#001C30" />
    <meta name="viewport" content="width=1024"/>
     <title>Samvaad • Login</title>
    <link rel="stylesheet" href="Style.css" type="text/css" media="all" />
        <link rel="icon" type="image/x-icon" href="/Media/S2.png"/>
    </head>
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
<button type="submit" onclick="window.location.href ='https://github.com/ParbinSharma'">Developer</button>
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
   <h1>Login</h1>
 <?php 
if ($anf) {
  echo "<div class='banner'>
 <span>Account not found.</span>
  <span style='background-color:red' class='progress'></span>
  </div>
  ";
}
if ($wpas) {
  echo "<div class='banner'>
 <span>Wrong Password.Try again.</span>
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
?>
   <form class="form" action="Login.php" method="post">
          <input class="credentials" type="text" name="username" id="username" placeholder="Username" required/>
          <input class="credentials" type="password" name="password" id="password" placeholder="password" required/>
          <input class="submit" type="submit" value="Login"/>
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