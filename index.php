<?php
	include_once('config.php');
	$conn = mysqli_connect($servername, $username, $password, $database);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico">
    <title><?php echo $title; ?></title>
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/timeclock.css" >
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">Clock In/Out</a></li>
            <li><a href="manualhours.php">Manual Entry</a></li>
            <li><a href="getloghours.php">Check Hours</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
            <form class="form-signin" method="post">
      <div id="alert">
      <?php 
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        if(isset($_POST['name'])) {
            $name = $_POST['name']; // Have a problem with my beautiful PHP? Why, did I change something? no you just were clicking through it very thuroghly.
            $clock = $_POST['clock'];
            $PIN = $_POST['pin'];
            $time = date('Y-m-d H:i:s');
            
            if(empty($_POST['pin'])){
              echo '<div class="alert alert-danger" role="alert">Please Provide a PIN!</div>';
            }else{
              $result = mysqli_query($conn,"SELECT * FROM `$user_table` WHERE `Name`='$name'");
    		
              while($row = mysqli_fetch_array($result)) {
                $server_pin = $row['pin'];
              }
              
              if($PIN !== $server_pin){
                echo '<div class="alert alert-danger" role="alert">Incorrect Pin</div>';
              }else{
                
                if($clock=='in'){
                  $sql = "INSERT INTO `$data_table` (`User`, `Time_In`) VALUES ('" . $name . "', '" . $time . "')";
                  $conn->query($sql);
                }elseif($clock=='out'){
                  $sql = "UPDATE `$data_table` SET Time_Out='$time' WHERE Time_Out IS NULL AND User='$name'";
                  $conn->query($sql);
                }
            
                
                echo '<div class="alert alert-success" role="alert">Hours Logged Sucessfully!</div>';
              }
            }
        }
        
      ?>
      </div>

        <h2 class="form-signin-heading"><?php echo $title; ?></h2>
        <!--<div class="btn-group btn-group-justified" style="width:100%;">
          <a class="btn btn-default active" href="index.php">Clock In/Out</a>
          <a class="btn btn-default" href="manualhours.php">Manual Entry</a>
        </div>
        <div class="btn-group btn-group-justified" style="width:100%;">
          <a class="btn btn-default" href="getloghours.php">Check Hours</a>
          <a class="btn btn-default" href="getloghours.php">Leaderboard</a>
        </div>-->
        <br>
        <input type="text" name="name" id="inputName" class=" form-control form-control-top" placeholder="Username" required autofocus>
        <input type="tel" name="pin" id="inputPassword" class="form-control form-control-bottom" placeholder="PIN" style="-webkit-text-security: disc;" maxlength="4">
        <div id="clockInOut"></div>
      </form>
    </div>
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/timeclock.js"></script>
  </body>
</html>