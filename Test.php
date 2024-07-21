<?php
require('db_connect.php');
session_start();
$random = $_POST["id"];
$blob=base64_encode($random);
//echo $random;
//echo $blob;
$Username = $_COOKIE['Username'];
if(isset($random)){
  //
    $check_pic_sql = "SELECT * FROM `Profile_images` WHERE `Username`='$Username'";
  $check_pic = mysqli_query($conn, $check_pic_sql);
  
  // if ($_FILES['uploadfile']['error'] == 4 || ($_FILES['uploadfile']['size'] == 0 && $_FILES['uploadfile']['error'] == 0)) {} else {
    
   // echo "into it";
        
     if (mysqli_num_rows($check_pic) == 1) {
       
       
       //$photo = addslashes(file_get_contents($_FILES['uploadfile']['tmp_name']));
      $update_pic_sql = "UPDATE `Profile_images` SET `Filename`='$blob' WHERE `Username`='$Username'";
      
       $update_pic = mysqli_query($conn, $update_pic_sql);
       if ($update_pic) {
         echo "<script>alert ('Refresh the page to see changed Profile image.');</script>";
       } else {
       echo mysqli_error($conn);
       }
       
       
       
       $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
 
// if($isMob){ 
//    $destination="Home.php";
// }else{ 
//     $destination="Dashboard.php";
// }
  header('location:'.$destination);
    } else {
       $insert_pic_sql = "INSERT INTO `Profile_images` (`Filename`,`Username`) VALUES ('$blob','$Username')";
      $insert_pic = mysqli_query($conn, $insert_pic_sql);
      if ($update_pic) {
         echo "updating";
       } else {
       echo mysqli_error($conn);
       }
      $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
 
// if($isMob){ 
//    $destination="Home.php";
// }else{ 
//     $destination="Dashboard.php";
// }
//   header('location:'.$destination);
    }
    // $photo = addslashes(file_get_contents($_FILES['uploadfile']['tmp_name']));
//     if (mysqli_num_rows($check_pic) == 1) {
//       $update_pic_sql = "UPDATE `Profile_images` SET `Filename`='$photo' WHERE `Username`='$Username'";
//       $update_pic = mysqli_query($conn, $update_pic_sql);
//     } else {
//       $insert_pic_sql = "INSERT INTO `Profile_images` (`Filename`,`Username`) VALUES ('$photo','$Username')";
//       $insert_pic = mysqli_query($conn, $insert_pic_sql);
//     }
  
  }else{
    echo "Something is wrong";
  }
 
//
//     $imageDataFirst = explode(";", $data);
//
//     $imageDataSecond = explode(",", $imageDataFirst[1]);
//
//     $data = base64_decode($imageDataSecond[1]);
//
//     $imageName = 'upload/' . time() . '.png';
//
//     file_put_contents($imageName, $data);
//
//     echo $imageName;
// }else{
//   echo 'no';
// }
//$base64=echo "<script>document.writeln(base64data);</script>";
//$echo $base64;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Crop Image Before Upload using CropperJS with PHP</title>
  <link rel="stylesheet" href="Style.css" type="text/css" media="all" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>

<style>

.image_area {
position: relative;
}

img {
display: block;
max-width: 100%;
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

.text {
color: #333;
font-size: 20px;
position: absolute;
top: 50%;
left: 50%;
-webkit-transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
text-align: center;
}

</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<br />



<div class="image_area">
<form method="post">



<!--<input type="file" name="image" class="upload-pic" id="uploadfile"/>-->

</form>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">




<img src="" id="output_image" />


<div class="preview"></div>






<button type="button" id="crop">Crop</button>



</div>
</div>
</div>


<div id="content"></div>
</body>
<script>

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