<?php
require('db_connect.php');
session_start();
if(!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] != true) {
    header("location: Login.php");

   exit;
}
$Id = $_GET['ProfileId'];
$Username = $_COOKIE['Username'];
$sql="SELECT * From `Accounts` WHERE `Id`='$Id'";
$query=mysqli_query($conn,$sql);
   $row = mysqli_fetch_assoc($query);
$username=$row['Username'];
$Name=$row['Name'];
$Email=$row['Email'];
$Description=$row['Description'];
$Date=substr($row['Date'], 0, -9);;
$Dob=$row['Dob'];


$get_sql="SELECT * FROM `ActivityChart` WHERE `Username`='$username'";
$get=mysqli_query($conn,$get_sql);
$raw=mysqli_fetch_assoc($get);

echo "<script>let Jan=".$raw['Jan'].";</script>";
echo "<script>let Feb=".$raw['Feb'].";</script>";
echo "<script>let Mar=".$raw['Mar'].";</script>";
echo "<script>let Apr=".$raw['Apr'].";</script>";
echo "<script>let May=".$raw['May'].";</script>";
echo "<script>let Jun=".$raw['Jun'].";</script>";
echo "<script>let Jul=".$raw['Jul'].";</script>";
echo "<script>let Aug=".$raw['Aug'].";</script>";
echo "<script>let Sept=".$raw['Sept'].";</script>";
echo "<script>let Oct=".$raw['Oct'].";</script>";
echo "<script>let Nov=".$raw['Nov'].";</script>";
echo "<script>let Decem=".$raw['Decem'].";</script>";

?>
<html>
  <head>
    <meta name="theme-color" content="#001C30" />
    <meta name="viewport" content="width=1024"/>
     <title>Samvaad • View</title>
    <link rel="stylesheet" href="Style.css" type="text/css" media="all" />
        <link rel="icon" type="image/x-icon" href="/Media/S2.png"/>
    </head>
      <body>
              <nav>
        <div class="logo-div">
      <img class="logo" src="Media/S2.png" alt="" />
        </div>
        
        <div class="nav-options">

        </div>
        
        <div class="register-login">
<button class="user" onclick="window.location.href ='/Profile.php'"><?php echo "@".$Username;?></button>
        </div>
      </nav>
      <svg viewBox="0 0 500 200">
<path opacity='0.7' fill='rgb(72,255,244)' d="M 0,170 C 200,250 250,100 500,120 L 500,00 L 0,0"></path>
</svg>

      <div class="containe">
        <div class="containe1">
          
          <?php
          
          $sql_member_image="SELECT * From `Profile_images` WHERE `Username`='$username'";
   $member_image=mysqli_query($conn,$sql_member_image);
   $member_image_rows = mysqli_fetch_assoc($member_image);
   $num=mysqli_num_rows($member_image);
   if ($num==1) {
  echo '<img class="view-img" src="'.base64_decode($member_image_rows['Filename']).'"/>';

   }
   else{
     echo '<img class="view-img" src="Media/profile50.png"/>';
   }
          
          
          ?>
        <!--  <img class="view-img" src="/Media/parbin.jpg">-->
          <p class="username69"><?php echo $username;?></p>
          <p class="name69"><?php echo $username;?>~</p>
          
        </div>
        
        
        
        <div class="containe2">
          <div>
            <p class="label">Name</p>
            <p class="pro-info"><?php echo $Name;?></p>
          </div>
          <div>
          <p class="label">Email</p>
            <p class="pro-info"><?php echo $Email;?></p>
          </div>
          <div>
            <p class="label">Account opening date</p>
            <p class="pro-info"><?php echo $Date;?></p> 
          </div>
          <div>
            <p class="label">Date Of birth</p>
            <p class="pro-info"><?php echo $Dob;?></p>
          </div>
          <div >
            <p  class="label">Description</p>
            <p style="font-size:10px;" class="pro-info"><?php echo $Description;?></p>
          </div>
      </div>
      </div>
     
     
     
     
     
     <div class="wrapp">
      
        <canvas id="myChart">Your browser does not support graphs</canvas>
      
      </div>
      

      
      
      </body>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

    
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'],
      datasets: [{
        label: 'Activity Score',
        data: [Jan, Feb, Mar, Apr, May, Jun,Jul,Aug,Sept,Oct,Nov,Decem],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    font: {
                        size: 18,
                        
                    }
                }
            },
            title: {
                display: true,
                text: 'Activity Graph',
                font:{
                  size:30
                }
            }
        },
      scales: {
        y: {
          beginAtZero: true
        }
      },
      responsive: false
    }
  });
  Chart.defaults.color = "#ffffff";
//Chart.defaults.backgroundColor = '#000000';
Chart.defaults.borderColor = '#ffffff';
//Chart.defaults.color = '#ffffff';
  
  </script>
      </html>