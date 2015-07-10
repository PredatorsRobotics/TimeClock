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
    			
				<h2>Robotics Hour Checker</h2>
				<p>Looking to log your hours? Click <a href="index.php">here</a></p>
				<input type="text" name="name" id="inputTimeIn" class="form-control form-control-bottom" placeholder="Name" required>
				<br />
				<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
			</form>
			<?php
				// Create connection
				$conn = mysqli_connect($servername, $username, $password, $database);
				
				// Check connection
				if (!$conn) {
				    die("Connection failed: " . mysqli_connect_error());
				}
				
				if(isset($_POST['name']))
				{
				    $name = $_POST['name'];
				    
				    echo "Student Name: <b>" . $name . "</b><br/>"
				    
				    ?>
				
						
					<table border="1">
						<tr>
							<th width="100">Day</th>
							<th width="100">Month</th>
							<th width="50">Year</th>
							<th width="75">Check-In</th>
							<th width="75">Check-Out</th>
							<th width="100">Total Hours</th>
						</tr>
		                <?php
		                $result = mysqli_query($conn,"SELECT * FROM `hours` WHERE `User` = '$name'");
		
		                while($row = mysqli_fetch_array($result)) {
		                 
		                    echo "<tr>";
		                    echo "<td>Day</td>";
		                    echo "<td>Month</td>";
		                    echo "<td>Year</td>";
		                    echo "<td>" . $row['Time_In'] . "</td>";
		                    echo "<td>" . $row['Time_Out'] . "</td>";
		                    echo "<td> Total! </td>";
		                    
		                }
		                ?>
					</table>
					
					<br/>
					Total Hours: <b>2.00</b><br/>
					Required Hours: <b>100 Hours</b><br/>
					Hours remaining: <b>98.00</b> (2% complete)<br/>
					If there are any errors please contact us!
					
			<?php } ?>
		</div>
				
				
	</body>
</html>