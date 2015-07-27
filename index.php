<?php
	include_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico">
    <title><?php echo $title; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/timeclock.css" >
  </head>
  <body>
    <div class="container">
      <div id="alert">
      <?php 
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        if(isset($_POST['name'])) {
            $name = $_POST['name'];
            $clock = $_POST['clock'];
            $time = date('Y-m-d H:i:s');
            
            if($clock=='in'){
              $sql = "INSERT INTO `$data_table` (`User`, `Time_In`) VALUES ('" . $name . "', '" . $time . "')";
              $conn->query($sql);
            }elseif($clock=='out'){
              $sql = "UPDATE `$data_table` SET Time_Out='$time' WHERE Time_Out IS NULL AND User='$name'";
              $conn->query($sql);
            }
        
            
            echo '<div class="alert alert-success" role="alert">Hours Logged Sucessfully!</div>';
        }
        
      ?>
      </div>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading"><?php echo $title; ?></h2>
        <div class="btn-group btn-group-justified" style="width:100%;">
          <a type="button" class="btn btn-default" href="getloghours.php">Check Hours</a>
          <a type="button" class="btn btn-default" href="manualhours.php">Manual Entry</a>
        </div>
        <br>
        <input type="text" name="name" id="inputName" class=" form-control form-control-top" placeholder="Username" required autofocus>
        <input type="tel" name="password" id="inputPassword" class="form-control form-control-bottom" placeholder="PIN" style="-webkit-text-security: disc;" maxlength="4">
        <div id="clockInOut"></div>
      </form>
    </div>
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="/timeclock.js"></script>
  </body>
</html>