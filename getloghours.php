<?php
	include_once('config.php');
	$required = 30;
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
		                $page_total = 0;
		                $result = mysqli_query($conn,"SELECT * FROM `hours` WHERE `User` = '$name'");
		
		                while($row = mysqli_fetch_array($result)) {
		                 	
		                 	$mysqltime = $row['Date'];
		                 	$time_in = $row['Time_In']; 
		                 	$time_out = $row['Time_Out'];
		                 	
		                 	$date = strtotime($mysqltime);
		                 	$total = ( ( strtotime($time_out) - strtotime($time_in) ) / 60 ) / 60;
		                 	
		                    echo "<tr>";
		                    echo "<td>" . date('l', $date) . "</td>";
		                    echo "<td>" . date('F j', $date) . "</td>";
		                    echo "<td>" . date('Y', $date) . "</td>";
		                    echo "<td>" . $time_in . "</td>";
		                    echo "<td>" . $time_out . "</td>";
		                    echo "<td>" . $total . "</td>";
		                    
		                    $page_total = $page_total + $total;
		                    
		                }
		                
		                $remaining = $required - $page_total;
		                
		                $count1 = $page_total / $required;
						$count2 = $count1 * 100;
						$count = number_format($count2, 0);
		                ?>
					</table>
					
					<br/>
					Total Hours: <b><?php echo $page_total; ?></b><br/>
					Required Hours: <b><?php echo $required; ?> Hours</b><br/>
					Hours remaining: <b><?php echo $remaining; ?></b></b> (<?php echo $count; ?>% complete)<br/>
					If there are any errors please contact us!
					
			<?php } ?>
		</div>
				
				
	</body>
</html>