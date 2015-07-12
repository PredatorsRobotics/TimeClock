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
		                 	$rounded_total = number_format($total, 2);
		                 	
		                    echo "<tr>";
		                    echo "<td>" . date('l', $date) . "</td>";
		                    echo "<td>" . date('F j', $date) . "</td>";
		                    echo "<td>" . date('Y', $date) . "</td>";
		                    echo "<td>" . $time_in . "</td>";
		                    echo "<td>" . $time_out . "</td>";
		                    echo "<td>" . $rounded_total . "</td>";
		                    
		                    $page_total = $page_total + $total;
		                    
		                }
		                
		                $rem_comp = $req_comp - $page_total;
		                $rem_letter = $req_letter - $page_total;
		                
		                $per_comp1 = $page_total / $req_comp;
						$per_comp2 = $per_comp1 * 100;
						$per_comp = number_format($per_comp2, 0);
						
						$per_letter1 = $page_total / $req_letter;
						$per_letter2 = $per_letter1 * 100;
						$per_letter = number_format($per_letter2, 0);
						
		                ?>
					</table>
					
					<br/>
					Total Hours: <b><?php echo $page_total; ?></b><br/>
					
					Required Hours: <b><?php echo $req_comp; ?> Hours</b><br/>
					Hours until you can go to Competition: <b><?php echo $req_comp; ?> Hours</b>
					<div class="progress">
					  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($per_comp >= 100){echo 100;}else{ echo $per_comp;} ?>%;">
					    <?php if($per_comp >= 100){echo $req_comp . " Hours";}else{echo $page_total . " Hours";} ?>
					  </div>
					  <center><?php if($per_comp <= 100){echo $rem_comp . " Hours";} ?></center>
					</div>
					Hours until you Letter: <b><?php echo $req_letter; ?> Hours</b>
					<div class="progress">
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($per_letter >= 100){echo 100;}else{ echo $per_letter;} ?>%;">
					    <?php if($per_letter >= 100){echo $req_letter . " Hours";}else{echo $page_total . " Hours";} ?>
					  </div>
					  <center><?php if($per_letter <= 100){echo $rem_letter . " Hours";} ?></center>
					</div>
					If there are any errors please contact us!
					
			<?php } ?>
		</div>
				
				
	</body>
</html>