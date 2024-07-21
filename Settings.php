<?php
session_start();

require('db_connect.php');
$logout=$_GET['logout'];

if ($logout) {
 // $resulttt= "68his928gs";
 setcookie('loggedin',false,time() + (86400 * 30), "/");
setcookie('Username'," ",time() + (86400 * 30), "/");
 header("Location: Login.php");
} else {
 // $sww=true;
  //echo "prbl 1";
}
function logout() {
header("location: Login.php");
  session_destroy();

exit;
}
if(array_key_exists('Log', $_POST)){
  logout();
} 
?>




<!DOCTYPE html>
<html>
<head>
      <meta name="theme-color" content="#001C30" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1024">

<title>Samvaad • Settings</title>
<link rel="icon" type="image/x-icon" href="/Media/S2.png" />
<link rel="stylesheet" href="Style.css" type="text/css" media="all" />
</head>
<body>
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

</div>
</nav>
<div class="details-box">
<details>
<summary>
Contact
</summary>
<div class="block">
<div class="mapouter">
<div class="gmap_canvas">
<iframe title='map' class="gmap_iframe" width="80%" frameBorder="0" scrolling="no" marginHeight="0" marginWidth="0" src="https://maps.google.com/maps?width=410&amp;height=446&amp;hl=en&amp;q=22.502857,88.331048&amp;t=&amp;z=7&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
</div>
</div>
<div class="contact">
<form action="https://formsubmit.co/sharmaparbin91@gmail.com" method="POST">
<input type="text" class="input" name="name" placeholder="Name" required />
<input class="input" placeholder='Email' type="email" name="email" required />
<input class="input" type="hidden" name="_subject" value="New Mail :PARBIN" />
<input class="input" placeholder='Subject' type="text" name="subject" required />
<textarea placeholder="Your Message" class="input" name="message" rows="10" required></textarea>
<input type="text" name="_honey" style='display:none' />
<input type="hidden" name="_autoresponse" value="We have recieved your email." />
<input type="hidden" name="_template" value="table" /><br />
<button class='but' type="submit">Submit</button>
</form>
</div>
</div>
</details>
<hr/>
<?php
if ($_COOKIE['Username']==" "||$_COOKIE['loggedin'] != true||!isset($_COOKIE['loggedin'])) {
  
}else{
  echo "<details>
  <summary>
    Logout
  </summary>
  <div class='logout-row'>
    Do you want to logout of your id?
       <form method='post' action='Dashboard.php?logout=true'>  <input type='submit' style='width:150px;height:50px;font-size:22px;' name='Log' id='Log' class='log' value='Confirm' />
      </form> 
  </div>
</details>
<hr />";
}


?>






</div>


</body>
</html>