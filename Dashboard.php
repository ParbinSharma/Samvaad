<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require('db_connect.php');
if(!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] != true) {
    header("location: Login.php");

   exit;
}
// Check if 'Logout' is set, otherwise default to null
$logout = isset($_GET['Logout']) ? $_GET['Logout'] : null;

// Check if 'data' is set, otherwise default to 'Samvaad'
$resulttt = isset($_GET['data']) ? $_GET['data'] : 'Samvaad';



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
                                        setcookie('loggedin',false,time() + (86400 * 30), "/");
                                        setcookie('Username'," ",time() + (86400 * 30), "/");
                                        setcookie('UID'," ",time() + (86400 * 30), "/");

                                        header("Location: Login.php");
                                        } else {
                                         // $sww=true;
                                          //echo "prbl 1";
                                        }
if ($_COOKIE['LOGIN_TYPE']==="Teacher") {
  $Username = $_COOKIE['UID'];
  $database = "teacher_acc";
  $column= "UID";
  echo "<style>#profile_icon{display:none;}</style>";
} elseif($_COOKIE['LOGIN_TYPE']==="Student"){
  $Username = $_COOKIE['Username'];
 $database = "student_acc";
  $column= "Username";
}

          
                                        
// $Username = $_COOKIE['Username'];
$date = getdate();
$month = $date['mon']; 
$year = $date['year'];


// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
// header("location: S_login.php");
//   exit;
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
if(isset($_POST['chat_name'])){
  // echo ("<script>alert('hello');</script>");
  $chat_name = mysqli_real_escape_string($conn,$_POST['chat_name']);
 global $id;
     $id=bin2hex(openssl_random_pseudo_bytes(5));
 $ins_sql="INSERT INTO `chat_bond` (`Chat_Name`,`Chat_id`) VALUES ('$chat_name','$id')";
 $ins=mysqli_query($conn,$ins_sql);
  if ($ins) {
 $create_sql = "CREATE TABLE `$id` (
serial int AUTO_INCREMENT PRIMARY KEY,
User VARCHAR(50) NOT NULL,
Message VARCHAR(255) NOT NULL,
Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
  $create = mysqli_query($conn, $create_sql);

   if ($create) {
    $join_sql = "INSERT INTO `chat_members` (`member`, `Chat_id`) VALUES ('$Username', '$id')";

    $join = mysqli_query($conn, $join_sql);
header('location:Dashboard.php?data='.$id);
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
 $get_chat_name_sql="SELECT `Chat_Name` FROM `chat_bond` WHERE `Chat_id`='$join_name'";
$get_chat_name=mysqli_query($conn,$get_chat_name_sql);
$rew=mysqli_fetch_assoc($get_chat_name);
$NAME=$rew["Chat_Name"];
    
    
    
  $table_exist_sql = "SELECT * FROM `chat_members` WHERE `Chat_id`='$join_name' AND `member`='$Username'";
  $table_exists = mysqli_query($conn, $table_exist_sql);
  $num_rows = mysqli_num_rows($table_exists);


$check_sql="SELECT * FROM `chat_bond` WHERE `Chat_id`='$join_name'";
$check= mysqli_query($conn,$check_sql);
$check_num= mysqli_num_rows($check);





  //if ($num_rows == 0 && $check_num !== 0) {
if($check_num !==0){
     if($num_rows ==0){
  
    $join2_sql = "INSERT INTO `chat_members` (`Member`, `Chat_id`) VALUES ('$Username', '$join_name')";
    $join2 = mysqli_query($conn, $join2_sql);
//$resulttt=$join_name;
        // $join_samvaad_sql = "INSERT INTO `Room_members` (`Members`, `Rooms`) VALUES ('$Username', 'Samvaad')";
//     $join_samvaad = mysqli_query($conn, $join_samvaad_sql);
    if ($join2) {
      //echo "joined zindex2";
      $resulttt=$join_name;
      header("Location: Dashboard.php?data=$resulttt");
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

$sql="SELECT * FROM `chat_bond` WHERE `Chat_id`='$resulttt'";
  $sq=mysqli_query($conn,$sql);
$s=mysqli_fetch_assoc($sq);
$i=$s['Chat_Name'];
if(isset( $_POST['message'])){


$message = mysqli_real_escape_string($conn,$_POST['message']);
$send_sql="INSERT INTO `$resulttt` (`serial`, `User`, `Message`, `Time`) VALUES (NULL, '$Username', '$message', current_timestamp())";
$send=mysqli_query($conn,$send_sql);
if ($send) {
 // echo "Sent";
}
else{
 // echo mysqli_error($conn);
 $sww=true;
// echo 'prblm 3';
}
}


function logout() {
   // echo " <div class='loggedout'>
                                         // $resulttt= "68his928gs";
                                        setcookie('loggedin',false,time() + (86400 * 30), "/");
                                        setcookie('Username'," ",time() + (86400 * 30), "/");
                                        setcookie('Username'," ",time() + (86400 * 30), "/");

                                        header("Location: Login.php");
  session_destroy();
header("location: Login.php");
//   <div class='popup' style='background-color:yellow;'>
// You have been logged out.
//  <a href='S_login.php' class='divert'>Login</a>
//       </div>
//       </div>";
exit;
}
?> 
<html>
  <head>
    <meta name="theme-color" content="#001C30" />

    <meta name="viewport" content="width=device-width,initial-scale=1">

     <title>Samvaad • <?php echo $Username?></title>
    <link rel="stylesheet" href="Style.css?v=<?php echo time(); ?>" type="text/css" media="all" />
     <link rel="icon" type="image/x-icon" href="Media/S2.png"/>
    <head>
<body>
  

  
  
                    <nav>
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
 <button class="mob-icons-btn" style="display:none;" id="plus" ><img src="Media/plus2.png" class="mob-icons" /></button>
<button class="user" onclick="window.location.href ='/Profile.php'"><?php echo "@".$Username;?></button>
        </div>
      </nav>

<!--<form method="POST" action="Dashboard.php" name="Counter_form">
  <input type="hidden" name="count" id="count" value="count"/>
</form>-->


<div class="main-nav">
  <img class="icons" style="margin-top:20px" onclick="window.location.href ='/Dashboard.php'" src="Media/home50.png" alt="" />
  <img class="icons" id="profile_icon" style="margin-top:50px" onclick="window.location.href ='/Profile.php'" src="Media/profile.png" alt="" />
  <img class="icons" onclick="window.location.href ='/index.html'" src="Media/about50.png" alt="" />

  <img class="icons" onclick="window.location.href ='https://parbinsharma.github.io/Samvaad/Contact.html'" src="Media/settings50.png" alt="" />
<button name="Logout" id="Logout" class="logout"></button>
</div>

<div id="logout-box">
  <div class="popup" style="border:2px solid red">
    Are you sure you want to logout?
    <div class="options">
      <button type="button" onclick="turnoff()" style="color:white" class="can">Cancel</button>
   <form method="post" action="Dashboard.php?logout=true">  <input type="submit" name="Log" id="Log" class="log" value="Confirm" />
      </form> 
    </div>
  </div>
  </div>





<div class="convos">
  

<div class="c-j">
    <button id="room" class="c-j-button">Create Chat</button>
  <button id="join" class="c-j-button">Join Chat</button>
  






  <div class="room_box" id="room_box">
    <div class="popup">
         <form action="Dashboard.php" method="post"> 
      <input type="text" class="c-j-input" name="chat_name" id="chat_name" placeholder="Name of the room" required/>
      <div class="options">
    <button type="button" class="can" onclick="turnoff2()">Cancel</button>
    <input type="submit" class="c-j-submit" name="create" id="create" value="create" />
      </div>
</form>
    </div>
</div>



<div id="join_box">
  <div class="popup">
     <form action="Dashboard.php" method="post"> 
<input type="text" class="c-j-input" name="join_name" id="join_name" placeholder="Enter the room name" required />
<div class="options">
    <button type="button" class="can" onclick="turnoff2()">Cancel</button>
<input type="submit" class="c-j-submit" name="join" id="join" value="join" />
</div>
</form>
  </div>
</div>
</div>


  
 
  
 <form method="get" name="form" action="Dashboard.php">
<div class="chat-box">
 <?php
$all_rooms_sql = "SELECT * FROM `chat_members` WHERE `member`='$Username' ORDER BY `Serial_no` DESC";
$all_rooms = mysqli_query($conn, $all_rooms_sql);

while ($row = mysqli_fetch_assoc($all_rooms)) {
  $hey=$row['Chat_id'];
$sequel="SELECT * FROM `chat_bond` WHERE `Chat_id`='$hey'";
$seq=mysqli_query($conn,$sequel);
$rin=mysqli_fetch_assoc($seq);
//echo "<input type='submit' id='data' name='data' value='".$row['Rooms']."'/>";




echo "<button type='submit' class='data' id='".$row['Chat_id']."' name='data' value='".$row['Chat_id']."'>".$rin['Chat_Name']."</button>";
// echo "<button type='submit' class='data' id='".$row['Chat_id']."' name='data' value='".$row['Chat_id']."'>".$rin['Chat_name']."</button>";

}
?> 
</div>
</form>



<?php 


function leave(){
 global $conn;
 global $Username;
 global $resulttt;
 
 $leave_sql="DELETE FROM `chat_members` WHERE `chat_members`.`Member` = '$Username' AND `Chat_id` = '$resulttt'";
  $leave=mysqli_query($conn,$leave_sql);
  $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
  
  if($isMob){ 
   $destination="redirect.html";
}else{ 
    $destination="Dashboard.php?data=Samvaad";
}
  if ($leave) {
// echo "<meta http-equiv='refresh' content='0;".$destination."' />";
 //header('location:'.$destination);
 echo '<script>window.location.href = "/'.$destination.'";</script>';
$leaved=true;
   exit();
  }
  else {
  //  echo "something went wrong";
   // echo mysqli_error($conn);
   $sww=true;
   
  }
  return $resulttt;
}
?>


</div>
<div class="room-banner" style="height:30px;">
  <div style="font-size:18px;">
  <?php echo $i?>
  </div>
  <button id="menu" style="width:30px;height:30px;z-index:89;margin-right:20px"><img style="width:20px;height:20px;"  src="Media/dots.png"/></button>
  <button id="cross" style="width:30px;height:30px;z-index:89;"><img style="width:25px;height:25px;"  src="Media/cross.png"/></button>
</div>



<div class="chats-window" id="chats-window">
  <div class="wrap">
    <div class="end-to-end">
      Messages are end to end encrypted.No one outside of this chat can read these messages.
    </div>
    <?php


if(array_key_exists('Log', $_POST)){
  logout();
  
} 


//echo $i;
$chats_sql="SELECT * FROM `$resulttt`";
$chats_query=mysqli_query($conn,$chats_sql);

while ($chats = mysqli_fetch_assoc($chats_query)) {
if($chats['User']==$Username){
echo "  <div class='my-chat-row'>
    <div class='my-chat'>
    <p class='You'>You</p>
  <p class='msg'>".$chats['Message']."</p>
  <p class='msg-time'>".date('H:i',strtotime($chats["Time"]))."</p>  
    </div>
  </div>";
}
else{
echo "<div class='chat-row'>
    <div class='user-chat'>
   <p class='Sender'>".$chats['User']."</p>
  <p class='msg'>".$chats['Message']."</p>
  <p class='msg-time'>".date('H:i',strtotime($chats["Time"]))."</p>
    </div>
  </div>";
}
}











 
?>  
  </div>
  
  
  
 
  
  
  

  
 
  
  
  <div id="sendbox">
 <form action="Dashboard.php?data=<?php echo $resulttt ?>" method="post" id="sendform">
<input class="message" type="text" name="message" id="message" placeholder="Message" required/>
<button type="submit" id="send1" name="send"><img class="send-img" src="Media/sendimg.png"/></button>
</form>
</div>

</div>


  
  <!-- <form method="get" name="form" action="Dashboard.php">
<div class="chat-box">
 <!--// <?php
//$all_rooms_sql = "SELECT * FROM `chat_members` WHERE `member`='$Username' ORDER BY `Chat_id` DESC";
//$all_rooms = mysqli_query($conn, $all_rooms_sql);

//while ($row = mysqli_fetch_assoc($all_rooms)) {
 // $hey=$row['Chat_id'];
//$sequel="SELECT * FROM `chat_bond` WHERE `Chat_id`='$hey'";
//$seq=mysqli_query($conn,$sequel);
//$rin=mysqli_fetch_assoc($seq);
//echo "<input type='submit' id='data' name='data' value='".$row['Rooms']."'/>";




//echo "<button type='submit' class='data' id='".$row['Chat_id']."' name='data' value='".$row['Chat_id']."'>".$rin['Chat_name']."</button>";
//}
?>  -->
<!-- </div>
</form> -->
  



<div class="room-info" id="room-info">
<p id="chat-name"><?php echo $i ?></p>
  <p class="mem">Members</p>
<div class="Members">
  <form action="View.php" method="get">
    

  <?php
$sql_members="SELECT * FROM `chat_members` WHERE `Chat_id`='$resulttt'";
 $members=mysqli_query($conn,$sql_members);
 while ($member_names = mysqli_fetch_assoc($members)) {
   $parbin=$member_names['member'];
   $sql69="SELECT * FROM `$database` WHERE `$column`='$parbin'";
   $query69=mysqli_query($conn,$sql69);
   if ($query69 && mysqli_num_rows($query69) > 0) {
   $row69 = mysqli_fetch_assoc($query69);
     
//     if ($_COOKIE['LOGIN_TYPE']==="Teacher") {
//   $parbin_id=$row69['UID'];
// } elseif($_COOKIE['LOGIN_TYPE']==="Student"){
//     $parbin_id=$row69['Username'];

// }

      $parbin_id=$row69['Name'];

   
   echo '  <div class="mem-div">';
   
  //  $sql_member_image="SELECT * From `Profile_images` WHERE `Username`='$parbin'";
  //  $member_image=mysqli_query($conn,$sql_member_image);
  //  $member_image_rows = mysqli_fetch_assoc($member_image);
  //  $num=mysqli_num_rows($member_image);
  //  if ($num==1) {
  // echo '<img src="'.base64_decode($member_image_rows['Filename']).'"/>';

  //  }
  //  else{
  //    echo '<img src="Media/profile50.png"/>';
  //  }
   
    echo '<button type="submit" disabled name="ProfileId" class="ProfileId" id="'.$parbin.'" value="'.$parbin_id.'">'.$parbin_id.'</button>
   </div>';
 }
}
 echo "<script>
 let code='$resulttt';
 </script>";
 echo "<script>let resulttt = '$i';</script>";
 $invite_code_sql="SELECT * FROM `chat_bond` WHERE `Chat_id`='$i'";
 $invite_code=mysqli_query($conn,$invite_code_sql);
 $rope=mysqli_fetch_assoc($invite_code);
//  $room_code=$rope['Chat_id'];
 ?>
    </form>
  
  

  
    

</div>
<div class="options">
  <button type="submit" name="leave" id="Leave" class="overlay">Leave</button>
  <button id="invite">Invite</button>
</div>


</div>

<div id="leave-box" class="popup">
  <div class="popup" style="border:2px solid red">
    Are you sure you want to leave this room?
  
    <div class="options">
   <button type="button" onclick="turnoff2()" style="color:white" class="can">Cancel</button>
   <form method="post" action="Dashboard.php?data=<?php echo $resulttt?>">  <input type="submit" name="Lea" id="Lea" class="lea" style="margin-top:15px;margin-left:20px;" value="Confirm" />
      </form> 
    </div>
  </div>
</div>


<div class="wrapper" id="wrapper">
  <div class="invite-div">
  Copy this code and send this to your friend <br />
 <p id="code"><?php echo $resulttt?></p>  <br />
  Use this code to join the chat.
  <div class="options">
    <button id="clo" type="submit">close</button>
    <button type="submit" id="copy" onclick="CopyToClipboard('code')">Copy</button>
  </div>
</div>
</div>

<?php
if(array_key_exists('Lea', $_POST)){
  leave();
}



?>
<div class="ai-div" onclick="window.location.href='Samvaad_ai.html';">
<img class="ai" src="Media/ai2.gif" alt="Ai" />
</div>
</body>
<script>
let leave_btn=document.getElementById('Leave');
let button_create = document.getElementById('room');
let button_join = document.getElementById('join');
button_create.addEventListener("click", myFunction_create);
button_join.addEventListener("click", myFunction_join);
var chatname = document.getElementById("chat-name");
var y = document.getElementById("join_box");
var x = document.getElementById("room_box");
let logout_box=document.getElementById('logout-box');
let leave_box=document.getElementById('leave-box');
let plus=document.getElementById('plus');
let cbox=false;
let jbox=false;
function turnoff(){
  y.style.display="none";
  x.style.display="none";
  logout_box.style.display="none";
 // leave_box.style.display="none";
  chatname.style.display="block";
 roominfo.style.display="flex";

}
function turnoff2(){

  y.style.display="none";
  chatname.style.display="block";
  leave_box.style.display="none";
  x.style.display="none";
  roominfo.style.display="flex";
}
plus.addEventListener('click',function(){
  button_create.style.display='block';
  button_join.style.display='block';
});
  





function myFunction_create() {
if (cbox==false) {
x.style.display = "flex";
y.style.display="none";
chatname.style.display="none";
roominfo.style.display="none";
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
chatname.style.display="none";
roominfo.style.display="none";
jbox=true;
} else {
y.style.display = "none";
jbox=false;
}
}




let sendbox=document.getElementById("sendbox");
setInterval(function() {
 // let devil=document.getElementById(code);
//devil.style.color='green';
if(resulttt=='Samvaad'){
  sendbox.style.display='none';
  leave_btn.style.display='none';
}
else{
  sendbox.style.display='block';
  leave_btn.style.display='flex';
}
},10);
let scroll_to_bottom = document.getElementById('chats-window');

		
	window.onload = function() {
	  scroll_to_bottom.scrollTop = scroll_to_bottom.scrollHeight;
	  
}
let invite_btn=document.getElementById('invite');
let invite_div=document.getElementById('wrapper');
let clo = document.getElementById('clo');
invite_btn.addEventListener('click',function(){
  invite_div.style.display='flex';
  roominfo.style.display="none";
});
clo.addEventListener('click',function(){
  invite_div.style.display='none';
  roominfo.style.display="flex";
});



let copy= document.getElementById('copy');
copy.addEventListener('click',function(){
  copy.innerHTML="Copied!";
  copy.style.backgroundColor="green";
}
);
function CopyToClipboard(containerid) {
  if (document.selection) {
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy");
  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(containerid));
    window.getSelection().addRange(range);
    document.execCommand("copy");
    
  }
}


let parbin= document.getElementById(code);
parbin.style.borderLeft="10px solid rgb(72,255,249)";
 // parbin.style.borderRight="1px solid rgb(72,255,249)";
//  parbin.style.borderTop="1px solid rgb(72,255,249)";
//  parbin.style.borderBottom="1px solid rgb(72,255,249)";
parbin.style.boxShadow="rgba(0, 0, 0, 1) 0px 10px 28px, rgba(0, 0, 0, 1) 0px 10px 10px";


let logout_btn=document.getElementById('Logout');

logout_btn.addEventListener("click",function(){
  logout_box.style.display='flex';
 roominfo.style.display="none";
});


let roominfo=document.getElementById("room-info");
leave_btn.addEventListener("click",function(){
  leave_box.style.display='flex';
  document.getElementById("room-info").style.display="none";
});
let Lea=document.getElementById("Lea");
Lea.addEventListener("click",function(){
  window.location.href = "Dashboard.php?data=Samvaad";
});
let roomBanner=document.getElementById("room-banner");

function RoomInformation(){
  
}


let menu =document.getElementById("menu");
let cross =document.getElementById("cross");

menu.addEventListener("click",function(){
  roominfo.style.display='flex';
  menu.style.display="none";
  cross.style.display="flex";
});
cross.addEventListener("click",function(){
  roominfo.style.display='none';
  menu.style.display="flex";
  cross.style.display="none";
})
// window.onload = function(){
//   document.forms['Counter_form'].submit();
// }
</script>
</html>