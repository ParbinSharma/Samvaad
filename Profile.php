<?php

require('db_connect.php');
session_start();
if (!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] != true) {
  header("location: Login.php");

  exit;
}
// $random = $_POST["id"];
// $blob=base64_decode($random);

//var_dump($_SESSION['username']);
$Username = $_COOKIE['Username'];


//$description = $_SESSION['description'];
$get_info_sql = "SELECT * FROM `student_acc` WHERE `Username`='$Username'";
$get_info = mysqli_query($conn, $get_info_sql);
$row = mysqli_fetch_assoc($get_info);
//$description = $row['Description'];
//$dob = $row['Dob'];
$name = $row['Name'];
$email = $row['Off_email'];
$year = $row['Year'];
$department = $row['Department'];


//$random = $_POST["id"];
       // $blob=base64_decode($random);
 

// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
//
//   header("location: S_login.php");
//
//   exit;
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //$upload_pic=$_POST["uploadfile"];
  
  
  
  //$up_description = mysqli_real_escape_string($conn,$_POST["up_description"]);
 // $up_dob = mysqli_real_escape_string($conn,$_POST["up_dob"]);
  $up_name = mysqli_real_escape_string($conn,$_POST["up_name"]);
  $up_email = mysqli_real_escape_string($conn,$_POST["up_email"]);
$up_year = mysqli_real_escape_string($conn,$_POST["up_year"]);
  $up_department = mysqli_real_escape_string($conn,$_POST["up_department"]);

  
  if(isset($up_description)||isset($up_name)||isset($up_email)||isset($up_dob)){
    // $sql = "UPDATE `Accounts` SET `Description`='$up_description',`Name`='$up_name',`Email`='$up_email',`Dob`='$up_dob' WHERE `Username`='$Username'";
  $sql= "UPDATE `student_acc` SET `Year` = '$up_year', `Department` = '$up_department' , `Name` = '$up_name' , `Off_email` = '$up_email' WHERE `student_acc`.`Username` = '$Username';";
    $add = mysqli_query($conn, $sql);
  // Check if the "mobile" word exists in User-Agent 
$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
 
if($isMob){ 
   $destination="Home.php";
}else{ 
    $destination="Dashboard.php";
}
  header('location:'.$destination);
}
  }
  
//$get_sql="SELECT * FROM `ActivityChart` WHERE `Username`='$Username'";
//$get=mysqli_query($conn,$get_sql);
//$raw=mysqli_fetch_assoc($get);

//echo "<script>let Jan=".$raw['Jan'].";</script>";
//echo "<script>let Feb=".$raw['Feb'].";</script>";
//echo "<script>let Mar=".$raw['Mar'].";</script>";
//echo "<script>let Apr=".$raw['Apr'].";</script>";
//echo "<script>let May=".$raw['May'].";</script>";
//echo "<script>let Jun=".$raw['Jun'].";</script>";
//echo "<script>let Jul=".$raw['Jul'].";</script>";
//echo "<script>let Aug=".$raw['Aug'].";</script>";
//echo "<script>let Sept=".$raw['Sept'].";</script>";
//echo "<script>let Oct=".$raw['Oct'].";</script>";
//echo "<script>let Nov=".$raw['Nov'].";</script>";
//echo "<script>let Decem=".$raw['Decem'].";</script>";

?>
<html>
<head>
  <?php

  //          $query = " SELECT * FROM `Profile_images` WHERE `Username`='$Username' LIMIT 1";
  //          $result2 = mysqli_query($conn, $query);
  //   if (mysqli_num_rows($result2)>0) {
  //                   $images_exists=true;
  //         //  header("Refresh:0");
  //            }
  //       elseif(mysqli_num_rows($result2)==0) {
  // $images_exists=false;
  //            }
  //  echo "<script>let images_exists = '$images_exists';</script>";

  // If upload button is clicked ...
  // if (isset($_POST['upload'])) {
  //
  //
  // if($images_exists==false){
  //
  //
  //     $sql = "INSERT INTO `Profile_images` (`Filename`,`Username`) VALUES ('$photo','$Username')";
  //
  //     // Execute query
  //     mysqli_query($conn, $sql);
  // }
  // else {
  //   echo 'image already exixts';
  // }
  // }






  ?>
  <meta name="theme-color" content="#001C30" />
<meta name="viewport" content="width=1024" />
<title>Samvaad • Profile</title>

 <link rel="icon" type="image/x-icon" href="Media/S2.png"/>
    <link rel="stylesheet" href="Style.css?v=<?php echo time(); ?>" type="text/css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>





<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
svg {
position: absolute;
top: 0;
}
body {
height:100%;

background-image: none;
background-color:#001C30 !important;
}


 option{
    color: black;
  }


.preview {
overflow: hidden;
width: 160px;
height: 160px;
margin: 10px;
border: 1px solid red;
}

.modal-lg {
max-width: 1000px !important;
}
.dev{
  display: none;
}
.overlay {
position: absolute;
bottom: 10px;
left: 0;
right: 0;
background-color: rgba(255, 255, 255, 0.5);
overflow: hidden;
height: 0;
transition: .5s ease;
width: 100%;
}

.image_area:hover .overlay {
height: 50%;
cursor: pointer;
}





</style>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </head>
  <style>
    body{
      overflow:hidden;
    }
  </style>
<body>
<nav>
<div class="logo-div">
<img class="logo" src="Media/S2.png" alt="" />
</div>

<div class="nav-options">
<button type="submit" onclick="window.location.href ='https://github.com/ParbinSharma'">Developer</button>
<button type="submit" onclick="window.location.href ='/index.html'">Info</button>
<button type="submit" onclick="window.location.href ='https://parbinsharma.github.io/Samvaad/Contact.html'">Contact</button>
</div>

<div class="register-login">
<!-- <button class="log-btn" type="submit">Login</button>
<button class="reg-btn" type="submit">Register</button> -->
<button class="user" onclick="window.location.href ='/Profile.php'"><?php echo "@".$Username; ?></button>
</div>
</nav>
<svg viewBox="0 0 500 400">
<path fill='rgb(46,223,239)' d="M 0,170 C 200,250 250,120 500,140 L 500,00 L 0,0"></path>
</svg>

<svg viewBox="0 0 500 400">
<path opacity='0.7' fill='rgb(47, 212, 179)' d="M 0,170 C 200,250 250,100 500,120 L 500,00 L 0,0"></path>
</svg>

<svg viewBox="0 0 500 400">
<path fill='rgb(15,150,156)' d="M 0,170 C 200,250 250,80 500,100 L 500,00 L 0,0"></path>
</svg>



<div class="devvv">
<div class="cont">

<?php
/* $query = " SELECT * FROM `Profile_images` WHERE `Username`='$Username' LIMIT 1";
$result2 = mysqli_query($conn, $query);
$num = mysqli_num_rows($result2);
if ($num == 1) {
while ($data = mysqli_fetch_array($result2)) {
echo '<img id="profile-pic" src="'.base64_decode($data['Filename']).'"/>';
echo $Username;
}
} else {
echo "<img id='profile-pic' src='Media/user.png'/> ";
} */
?>


<p class="user-h1" style="color:rgb(46,223,239)">
<?php echo '@'.$Username; ?>
</p>
<p class="user-h1">
<?php echo $name; ?>
</p>
<p id="edit">
Edit Profile
</p>
<p class="user-info" id="user-description">
<?php echo $year; ?>
</p>
<p class="user-info" id="user-email">
<?php echo $email; ?>
</p>
<p class="user-info" id="user-dob">
<?php echo $department; ?>
</p>
<!-- <button type="button" class="submit" style="top:380px;left:-110px;" id="submob" onclick="window.location.href ='/Home.php'" >Confirm</button> -->
<button type="button" class="submit" style="top:395px;left:-100px;" id="subdesk" onclick="window.location.href ='/Dashboard.php'" >Confirm</button>











<div id="edit_div">
<form method="POST" action="Profile.php" enctype="multipart/form-data">




<!-- <p id="ci">
Change image
</p> -->














<!--<img id="img" />

<div id="content"></div>-->









<!-- <form method="post">
<input type="file" name="image" class="image" id="upload_image" style="display:none" />
</form> -->







<input class="credentials" type="text" id="up_name" name="up_name" placeholder="Name" maxlength="24" onkeydown="limit(this);" value='<?php echo $name; ?>' onkeyup="limit(this);" />
<select class="credentials" id="up_department"  name="up_department">
    <option value='<?php echo $department; ?>'> <?php echo $department; ?></option>
    <option value="CSE 1">CSE 1</option>
    <option value="CSE 2">CSE 2</option>
    <option value="CSE 3">CSE 3</option>
    <option value="AI/ML">AI/ML</option>
    <option value="AI/ML">ECE</option>
    <option value="AI/ML">EE</option>
    <option value="IT">IT</option>
  </select>
<select class="credentials" value='<?php echo $year; ?>' id="up_year" name="up_year">
    <option value='<?php echo $year; ?>'> <?php echo $year; ?></option>
    <option value="1st Year">1st Year</option>
    <option value="2nd Year">2nd Year</option>
    <option value="3rd Year">3rd Year</option>
    <option value="4th Year">4th Year</option>
  </select>
  <input class="credentials" type="text" placeholder="Email" value='<?php echo $email; ?>' id="up_email" name="up_email" />
<p class="user" id="cancel">
close
</p>
<input type="submit" id="up_id" class="submit" value="Update" />
</form>
</div>

<div id="dp-div">
<p class="user" id="cancel2">
close
</p>


<form method="post">

 <input class="upload-pic" type="file" name="image"  accept="image/*" id="uploadfile" required/>

<button type="button" id="buuut" onclick="window.location.href ='/Profile.php'" >Confirm</button>


</div>
<!-- <input class="upload-pic" type="file" name="uploadfile" accept="image/*" id="uploadfile" />-->





<div id="content"></div>


</div>






 <!-- <div class="wrapp">
      
        <canvas id="myChart" style="width:450px;right:0;top:-70px;">Your browser does not support graphs</canvas>
      
      </div> -->

</div>



<div >

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="width:80%;left:10%;">
<div class="modal-dialog modal-lg" role="document" style="background-color:;">
<div class="modal-content test3" style="background-color: transparent;">




<img src="" id="output_image" style="height:800px;"/>


<div class="preview"></div>






<button type="button" id="crop">Confirm</button>



</div>
</div>
</div>
</div>

</body>
 <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
//   const ctx = document.getElementById('myChart');

    
//   new Chart(ctx, {
//     type: 'doughnut',
//     data: {
//       labels: ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'],
//       datasets: [{
//         label: 'Activity Score',
//         data: [Jan, Feb, Mar, Apr, May, Jun,Jul,Aug,Sept,Oct,Nov,Decem],
//         borderWidth: 1
//       }]
//     },
//     options: {
//       plugins: {
//             legend: {
//                 labels: {
//                     // This more specific font property overrides the global property
//                     font: {
//                         size: 18,
                        
//                     }
//                 }
//             },
//             title: {
//                 display: true,
//                 text: 'Activity Graph',
//                 font:{
//                   size:30
//                 }
//             }
//         },
//       scales: {
//         y: {
//           beginAtZero: true
//         }
//       },
//       responsive: false
//     }
//   });
//   Chart.defaults.color = "#ffffff";
// //Chart.defaults.backgroundColor = '#000000';
// Chart.defaults.borderColor = '#ffffff';
// //Chart.defaults.color = '#ffffff';
  
  




// let dp_div=document.getElementById("dp-div");
// let ci=document.getElementById("ci");
// let cancel2=document.getElementById("cancel2");
// cancel2.addEventListener("click", function() {
// let dp_div = document.getElementById("dp-div");
// dp_div.style.display = "none";
// });
// ci.addEventListener("click", function() {
// let dp_div = document.getElementById("dp-div");
// dp_div.style.display = "block";
// }
// );






let edit = document.getElementById("edit");
let cancel = document.getElementById("cancel");
cancel.addEventListener("click", function() {
let edit_div = document.getElementById("edit_div");
edit_div.style.display = "none";
});
edit.addEventListener("click", function() {

let edit_div = document.getElementById("edit_div");
edit_div.style.display = "block";
}
);
//       setInterval(function() {
//       if(images_exists){
//         upload_image.style.display='none';
//       }
//       else{
//         upload_image.style.display='block';
//       }
//       },10);
let element = document.getElementById('up_description');
function limit(element) {
var max_chars = 24;
if (element.value.length > max_chars) {
element.value = element.value.substr(0, max_chars);
}
}



let submob=document.getElementById("submob");
let subdesk=document.getElementById("subdesk");
if (navigator.userAgent.match(/Android/i)
         || navigator.userAgent.match(/webOS/i)
         || navigator.userAgent.match(/iPhone/i)
         || navigator.userAgent.match(/iPad/i)
         || navigator.userAgent.match(/iPod/i)
         || navigator.userAgent.match(/BlackBerry/i)
         || navigator.userAgent.match(/Windows Phone/i)) {
           subdesk.style.display="none";
           submob.style.display="";
         } else {
           submob.style.display="none";
           subdesk.style.display="block";
         }
         
         
         
         
         
         
     
  
  
     $(document).ready(function() {

const type_reg = /^image\/(jpg|png|jpeg|bmp|gif|ico|webp)$/;

let $modal = $('#modal');

let image = document.getElementById('output_image');

let cropper;

$('#uploadfile').change(function(event) {
let files = event.target.files;

let done = function(url) {
image.src = url;
$modal.modal('show');
};
let type = files[0].type;



if (! type_reg.test(type)) {
alert('Please Upload Valid Image of type jpg,png,jpeg,bmp,gif,ico,webp');
return false;
}

if (files && files.length > 0) {
reader = new FileReader();
reader.onload = function(event) {
done(reader.result);
};
reader.readAsDataURL(files[0]);
}
});

$modal.on('shown.bs.modal',
function() {
cropper = new Cropper(image, {
aspectRatio: 1,
viewMode: 1,
preview: '.preview'
});
}).on('hidden.bs.modal',
function() {
cropper.destroy();
cropper = null;
});

$('#crop').click(function() {
canvas = cropper.getCroppedCanvas({
width: 200,
height: 200
});

canvas.toBlob(function(blob) {
url = URL.createObjectURL(blob);
var reader = new FileReader();
reader.readAsDataURL(blob);

reader.onloadend = function() {
var base64data = reader.result;
//                 $.ajax({
//                   url: 'Upload.php',
//                     data:{x:base64data},
//                     type: 'POST',
//                     success: function(data) {
//                              // do something;
//                            // $('#result').html(data)
//                           // alert(data);
//                            alert("done");
//                         //   window.location.href="Upload.php";
//                          }
//                });
$modal.modal('hide');

//var image = document.getElementById("img");

//image.src = base64data;
//alert(base64data);
$.ajax({
        type:"POST",
        url:"Test.php",
        data:{id:base64data},
        success:function(result){
        $("#content").html(result);
        $("#submit").hide();
        
        }
        });

//$('#uploaded_image').attr('src', data);
//alert();
};
});

});

});
  




</script>
</html>