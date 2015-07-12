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
	<style type="text/css">
        .error {
            color: #ff0000;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="alert alert-danger alert-dismissible" role="alert">Important: Log hours in 24hr format! Example: 3:00 PM translates to 15:00 and 9:00 AM translates to 09:00</div>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading"><?php echo $title; ?></h2>
        <p>Looking to check your hours? Click <a href="getloghours.php">here</a></p>
        <p><span class="error">* required field.</span></p>
        <input type="text" name="name" id="inputName" class="form-control form-control-top" placeholder="Name" required autofocus>
        <!--<input type="password" name="password" id="inputPassword" class="form-control form-control-mid" placeholder="password">-->
		<input type="text" name="time_in" id="inputTimeIn" class="form-control form-control-bottom" placeholder="Time In" required>
		<input type="text" name="time_out" id="inputTimeIn" class="form-control form-control-bottom" placeholder="Time Out" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      </form>
    </div> <!-- /container -->
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>

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
    
    $sql = "INSERT INTO `$data_table` (`User`, `Date`, `Time_In`, `Time_Out`) VALUES ('" . $name . "', '" . $date . "', '" . $time_in . "', '" . $time_out . "')";
    
    $conn->query($sql);
    
    echo "<h2>Hours logged:</h2><br>";
    echo $name . "<br>";
    echo $time_in . "<br>";
    echo $time_out;
}

?>
