<?php
session_start();

require('db_connect.php');
$logout=$_GET['logout'];
$resulttt = $_GET['data'];
if (!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] != true) {
  header("location: Login.php");
//echo '<script>window.location.href = "/Login.php";</script>';
  exit;
}
$sww=false;
$created=false;
$joined=false;
$aig=false;
$rdne=false;
$leaved=false;
 if (isset($resulttt)===FALSE) {
  $resulttt="Samvaad";
}

if ($logout) {
 // $resulttt= "68his928gs";
 //header("Location: Login.php");
 echo '<script>window.location.href = "/Login.php";</script>';
setcookie('Username'," " ,time() - 3600);
} else {
 // $sww=true;
  //echo "prbl 1";
}
$Username = $_COOKIE['Username'];
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
// header("location: S_login.php");
//   exit;
// }
if(!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] != true) {
    header("location: Login.php");

   exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
if(isset($_POST['room_name'])){
  $room_name = mysqli_real_escape_string($conn,$_POST['room_name']);
     $code=bin2hex(openssl_random_pseudo_bytes(5));
 $ins_sql="INSERT INTO `Room_Codes` (`Room`,`Code`) VALUES ('$room_name','$code')";
 $ins=mysqli_query($conn,$ins_sql);
  if ($ins) {
 $create_sql = "CREATE TABLE `$code` (
serial int AUTO_INCREMENT PRIMARY KEY,
User VARCHAR(50) NOT NULL,
Message VARCHAR(255) NOT NULL,
Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
  $create = mysqli_query($conn, $create_sql);

   if ($create) {
    $join_sql = "INSERT INTO `Room_members` (`Members`, `Room_Code`) VALUES ('$Username', '$code')";

    $join = mysqli_query($conn, $join_sql);

    if ($join) {
      $created=true;
      
    } else {
      //echo mysqli_error($conn);
      $sww=true;
     // echo '33333';
    }
  } else {
    
    //echo mysqli_error($conn);
    $sww=true;
  //  echo '1111';
  }
}else{
  $sww=true;
//  echo '9999';
}
  
  
  
  

}




  
  if(isset($_POST['join_name'])){
    $join_name = mysqli_real_escape_string($conn,$_POST['join_name']);
 $get_room_name_sql="SELECT `Room` FROM `Room_Codes` WHERE `Code`='$join_name'";
$get_room_name=mysqli_query($conn,$get_room_name_sql);
$rew=mysqli_fetch_assoc($get_room_name);
$NAME=$rew["Room"];
    
    
    
  $table_exist_sql = "SELECT * FROM `Room_members` WHERE `Room_Code`='$join_name' AND `Members`='$Username'";
  $table_exists = mysqli_query($conn, $table_exist_sql);
  $num_rows = mysqli_num_rows($table_exists);


$check_sql="SELECT * FROM `Room_Codes` WHERE `Code`='$join_name'";
$check= mysqli_query($conn,$check_sql);
$check_num= mysqli_num_rows($check);





  //if ($num_rows == 0 && $check_num !== 0) {
if($check_num !==0){
     if($num_rows ==0){
  
    $join2_sql = "INSERT INTO `Room_members` (`Members`, `Room_Code`) VALUES ('$Username', '$join_name')";
    $join2 = mysqli_query($conn, $join2_sql);
//$resulttt=$join_name;
        // $join_samvaad_sql = "INSERT INTO `Room_members` (`Members`, `Rooms`) VALUES ('$Username', 'Samvaad')";
//     $join_samvaad = mysqli_query($conn, $join_samvaad_sql);
    if ($join2) {
      //echo "joined zindex2";
      $resulttt=$join_name;
      header("Location: Dashboard.php?data=".$code);
      $joined=true;
    } else {
    //  echo 'cant join';
      $sww=true;
     // echo 'peblm 7788';
    }
     }else{
     //already in that grp
     $aig=true;
     }
     
  }else{
  //room does not exists
$rdne=true;
  }
}



}

$sql="SELECT * FROM `Room_Codes` WHERE `Code`='$resulttt'";
  $sq=mysqli_query($conn,$sql);
$s=mysqli_fetch_assoc($sq);
$i=$s['Room'];





?>
<html>
  <head>
    <meta name="theme-color" content="#001C30" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Samvaad • <?php echo $Username?></title>
    <link rel="stylesheet" href="Style.css" type="text/css" media="all" />
     <link rel="icon" type="image/x-icon" href="/Media/S2.png"/>
    </head>
<body>
  

  
  
                    <nav style="display:flex;">
        <div class="logo-div">
      <img class="logo" src="Media/S2.png" alt="" />
        </div>
        <div class="kolkata">
  <?php
if ($sww) {
  echo "<div class='banner'>
 <span>Something went wrong.</span>
  <span style='background-color:red' class='progress'></span>
  </div>
  ";
}
if ($created) {
  echo "<div class='banner'>
 <span>Room Created.</span>
  <span style='background-color:green' class='progress'></span>
  </div>
  ";
}


if ($joined) {
  echo "<div class='banner'>
 <span>Joined the room.</span>
  <span style='background-color:green' class='progress'></span>
  </div>
  ";
}
if ($aig) {
  echo "<div class='banner'>
 <span>Already in the room.</span>
  <span style='background-color:blue' class='progress'></span>
  </div>
  ";
}
if ($rdne) {
  echo "<div class='banner'>
 <span>Room does not exists.</span>
  <span style='background-color:blue' class='progress'></span>
  </div>
  ";
}
if ($leaved) {
  echo "<div class='banner'>
 <span>Left the room.</span>
  <span style='background-color:red' class='progress'></span>
  </div>
  ";
}

?>
        </div>
        <div class="register-login">

<button class="user" onclick="window.location.href ='/Profile.php'"><?php echo "@".$Username;?></button>
        </div>
      </nav>
        <div class="room_box" id="room_box">
    <div class="popup">
         <form action="Home.php" method="post"> 
      <input type="text" class="c-j-input" name="room_name" id="room_name" placeholder="Name of the room" required/>
      <div class="options">
    <button type="button" class="can" onclick="turnoff()">Cancel</button>
    <input type="submit" class="c-j-submit" name="create" id="create" value="create" />
      </div>
</form>
    </div>
</div>



<div id="join_box">
  <div class="popup">
     <form action="Dashboard.php" method="post"> 
<input type="text" class="c-j-input" name="join_name" id="join_name" placeholder="Enter the room code" required />
<div class="options">
    <button type="button" class="can" onclick="turnoff()">Cancel</button>
<input type="submit" class="c-j-submit" name="join" id="join" value="join" />
</div>
</form>
  </div>
</div>
 <form method="get" name="form" action="Dashboard.php">
<div class="containment">
 <?php
$all_rooms_sql = "SELECT * FROM `Room_members` WHERE `Members`='$Username' ORDER BY `Id` DESC";
$all_rooms = mysqli_query($conn, $all_rooms_sql);

while ($row = mysqli_fetch_assoc($all_rooms)) {
  $hey=$row['Room_Code'];
$sequel="SELECT * FROM `Room_Codes` WHERE `Code`='$hey'";
$seq=mysqli_query($conn,$sequel);
$rin=mysqli_fetch_assoc($seq);
//echo "<input type='submit' id='data' name='data' value='".$row['Rooms']."'/>";
$sql3="SELECT * FROM `$hey` WHERE `serial` = (select max(serial) from `$hey`)";
$sql3=mysqli_query($conn,$sql3);
$last_row=mysqli_fetch_assoc($sql3);

if ($last_row['User']==$Username) {
  $variable="You";
}else{
  $variable=$last_row['User'];
}



echo "<button type='submit' class='data' id='".$row['Room_Code']."' name='data' value='".$row['Room_Code']."'>".$rin['Room']."<br/><div class='last-row'>".$variable." : ".$last_row['Message']."</div></button>";


}
?> 
</div>
</form>


<div id="box" class="plus-option-menu">
  <button id="room" type="submit">Create Room</button><hr/>
  <button id="join" onclick="myFunction_join()" type="submit">Join Room</button>
</div>


      <div class="mob-nav">
        <button class="mob-icons-btn" onclick="window.location.href ='/Home.php'"><img width="40" height="40" src="https://img.icons8.com/external-zen-filled-royyan-wijaya/100/external-chats-communication-zen-filled-royyan-wijaya.png" alt="external-chats-communication-zen-filled-royyan-wijaya"/></button>

        <span class="span"></span>
        
    <button class="mob-icons-btn" onclick="window.location.href ='/index.html'"><img src="/Media/info2.png" class="mob-icons" /></button>
    
          <span class="span"></span>
 <button class="mob-icons-btn" id="plus" onclick="toggle()"><img src="/Media/plus.png" class="mob-icons" /></button>
        
        <span class="span"></span>
        <button class="mob-icons-btn" onclick="window.location.href ='/Settings.php'"><img src="/Media/settings.png" class="mob-icons" /></button>
       
  <span class="span"></span>
    <?php
 $query = " SELECT * FROM `Profile_images` WHERE `Username`='$Username' LIMIT 1";
$result2 = mysqli_query($conn, $query);
$num = mysqli_num_rows($result2);
 if ($num == 1) {
while ($data = mysqli_fetch_array($result2)) {
echo '<button class="mob-icons-btn" onclick="window.location.href =`/Profile.php`"><img class="mob-icons" style="border-radius:50%;border:1px solid black;" src="'.base64_decode($data['Filename']).'"/></button>';

}
} else {
echo "<button class='mob-icons-btn' onclick='window.location.href =`/Profile.php`'><img class='mob-icons' src='Media/profile2.png'/></button>";
}

                
                ?>
        
      </div>
      
      
      
      
      
      </body>
      <script type="text/javascript" charset="utf-8">
        let plus =document.getElementById("plus");
        let box =document.getElementById("box");
        plus.addEventListener("click",()=>{
          if(box.style.display=="flex"){
            box.style.display="none";
          }else{
            box.style.display="flex";
          }
        })
        
        
        
        
        
        
   
  let button_create = document.getElementById('room');
let button_join = document.getElementById('join');
button_create.addEventListener("click", myFunction_create);
button_join.addEventListener("click", myFunction_join);
var y = document.getElementById("join_box");
var x = document.getElementById("room_box");
let cbox=false;
let jbox=false;
function myFunction_create() {
if (cbox==false) {
x.style.display = "flex";
y.style.display="none";
box.style.display="none";
//chatname.style.display="none";
cbox=true;
} else {
x.style.display = "none";
cbox=false;
}
}
function myFunction_join() {
if (jbox==false) {
y.style.display = "flex";
x.style.display = "none";
box.style.display="none";
//chatname.style.display="none";
jbox=true;
} else {
y.style.display = "none";
jbox=false;
}
}
function turnoff(){
  y.style.display="none";
  x.style.display="none";
  logout_box.style.display="none";
  leave_box.style.display="none";
  chatname.style.display="block";
}
      </script>
      </html>