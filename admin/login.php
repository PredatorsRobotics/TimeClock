<?php
	include_once('../config.php');
	$conn = mysqli_connect($servername, $username, $password, $database);
	session_start();
	
	if(isset($_GET['logout'])){
	  session_destroy();
	  header('Location: index.html');
	}
	
	if(isset($_POST['name'])){
	    $name = $_POST['name'];
	    $UNHASHED_PIN = $_POST['pin'];
	    $PIN = md5($UNHASHED_PIN);
	    
	    if(empty($_POST['pin'])){
        $error=4;
      }else{
        $result = mysqli_query($conn,"SELECT * FROM `$user_table` ( WHERE Name='$name' OR username='$name' ) AND pin IS NULL");
        $isnull = mysqli_num_rows($result);
              
        if($isnull == 0){
          $result = mysqli_query($conn,"SELECT * FROM `$user_table` WHERE `Name`='$name' OR `username`='$name'");
      		
          while($row = mysqli_fetch_array($result)) {
            $server_pin = $row['pin'];
          }
          
          if($PIN !== $server_pin){
            $error = 1; //INCORRECT PIN
          }
        }else{
          $error = 2; //NO PIN SET
        }
              
        if($PIN == $server_pin){
          $resultz = mysqli_query($conn,"SELECT * FROM `$user_table` WHERE `Name`='$name' OR `username`='$name' AND admin=1");
          $isadmin = mysqli_num_rows($resultz);
              
          if($isadmin == 1){
            $_SESSION['ADMIN'] = 1;
          }else{
            $error = 3;
          }
        }
      }
	}

    if($_SESSION['ADMIN'] == 1){
        header('location: index.php');
    }
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
	<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="../css/timeclock.css" >
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
          <a class="navbar-brand" href="../"><?php echo $title; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">Home</a></li>
            <li class="active"><a href="login.php">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
      <form class="form-signin" method="post">

        <h2 class="form-signin-heading">Admin</h2>
        <?php 
        switch ($error) {
            case 1:
                echo "INCORRECT PIN";
                break;
            case 2:
                echo "NO PIN SET";
                break;
            case 3:
                echo "YOUR NOT AN ADMIN";
                break;
            case 4:
                echo "YOU NEED TO ENTER A PIN";
                break;
        }
        ?>
        <br>
        <input type="text" name="name" id="inputName" class=" form-control form-control-top" placeholder="Username" required autofocus>
        <input type="tel" name="pin" id="inputPassword" class="form-control form-control-bottom" placeholder="PIN" style="-webkit-text-security: disc;" maxlength="4" autocomplete="off" autocorrect="off">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
      </form>
    </div>
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>