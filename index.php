<?php
	include_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="timeclock.css" >
  </head>
  <body>
    <div class="container">
      <form class="form-signin">
        <h2 class="form-signin-heading"><?php echo $title; ?></h2>
        <input type="text" id="inputName" class="form-control form-control-top" placeholder="Name" required autofocus>
        <input type="password" id="inputPassword" class="form-control form-control-mid" placeholder="password" required>
		<input type="text" id="inputTimeIn" class="form-control form-control-bottom" placeholder="Time In" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
<!--
<html>
    <head>
        <title><?php echo $title; ?></title>
        <style type="text/css">
            .error {
                color: #ff0000;
            }
        </style>
    </head>
    <body>
        <h2>Robotics Team Sign-In</h2>
        <p>Looking to check your hours? Click <a href="getloghours.php">here</a></p>
        <h3 style="color:#FF0000;">Important: Log hours in 24hr format!<br/>
        Example: 3:00 PM translates to 15:00 and <br/>9:00 AM translates to 09:00</h3>
        <p><span class="error">* required field.</span></p>
        <form method="post" action="index.php">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" required /><span class="error">* </span></td>
            </tr>
            <tr>
                <td>Time In:</td>
                <td><input type="text" name="time_in" required /><span class="error">* </span></td>
            </tr>
            <tr></tr>   
                <td>Time Out:</td>
                <td><input type="text" name="time_out" required /><span class="error">* </span></td>
            </tr>
            <tr>
                <td><input type="submit"/></td>
            </tr>
        </table>
        <?php 
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        if(isset($_POST['name'])) {
            $name = $_POST['name'];
            $time_in = $_POST['time_in'];
            $time_out = $_POST['time_out'];
            $date = date('Y-m-d');
            
            $sql = "INSERT INTO `hours` (`User`, `Date`, `Time_In`, `Time_Out`) VALUES ('" . $name . "', '" . $date . "', '" . $time_in . "', '" . $time_out . "')";
            
            $conn->query($sql);
            
            echo "<h2>Hours logged:</h2><br>";
            echo $name . "<br>";
            echo $time_in . "<br>";
            echo $time_out;
        }


        
        ?>
    </body>
</html>-->