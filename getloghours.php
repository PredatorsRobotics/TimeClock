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
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="css/timeclock.css" >
		<style type="text/css">
		    .error {
		        color: #ff0000;
		    }
		</style>
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
	            <li><a href="index.php">Clock In/Out</a></li>
	            <li><a href="manualhours.php">Manual Entry</a></li>
	            <li class="active"><a href="getloghours.php">Check Hours</a></li>
	            <li><a href="leaderboard.php">Leaderboard</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>
		<div class="container">
    		<form class="form-signin" method="post">
				<h2 class="form-signin-heading"><?php echo $title; ?></h2>
		        <br>
				<input type="text" name="name" id="inputTimeIn" class="form-control" placeholder="Name" <?php if(isset($_POST['name'])){echo 'value="' . $_POST['name'] . '"';} ?> required>
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
				    
				    echo "<h3>Student Name: <b>" . $name . "</b></h3>"
				    
				    ?>
				
						
					<table border="1" class="table table-bordered">
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
		                $result = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE `User` = '$name' AND `Time_Out` IS NOT NULL AND Status=1");
		
		                while($row = mysqli_fetch_array($result)) {
		                 	
		                 	$time_in = $row['Time_In'];
		                 	$time_out = $row['Time_Out'];
		                 	
		                 	$total = ( ( strtotime($time_out) - strtotime($time_in) ) / 60 ) / 60;
		                 	$rounded_total = number_format($total, 1);
		                 	
		                    echo "<tr>";
		                    echo "<td>" . date('l', strtotime($time_in)) . "</td>";
		                    echo "<td>" . date('F j', strtotime($time_in)) . "</td>";
		                    echo "<td>" . date('Y', strtotime($time_in)) . "</td>";
		                    echo "<td>" . date("g:i A", strtotime($time_in)) . "</td>";
		                    echo "<td>" . date("g:i A", strtotime($time_out)) . "</td>";
		                    echo "<td>" . $rounded_total . "</td>";
		                    
		                    $page_total = $page_total + $total;
		                    
		                }
		                
		                $page_total = number_format($page_total, 1);
		                
		                //RRMAINING
		                $rem_comp = $req_comp - $page_total;
		                $rem_letter = $req_letter - $page_total;
		                
		                //PERCENTAGES
		                $per_comp1 = $page_total / $req_comp;
						$per_comp2 = $per_comp1 * 100;
						$per_comp = number_format($per_comp2, 0);
						
						$per_letter1 = $page_total / $req_letter;
						$per_letter2 = $per_letter1 * 100;
						$per_letter = number_format($per_letter2, 0);
						
		                ?>
					</table>
					
					<br/>
					<h3>Total Hours: <b><?php echo $page_total; ?></b><br/></h3>
					
					<h5>Hours Required to go to Competition: <b><?php echo $req_comp; ?> Hours</b><br>
					Your Progress: <?php echo $per_comp . "%"; ?></h5>
					<div class="progress">
					  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($per_comp >= 100){echo 100;}else{ echo $per_comp;} ?>%;">
					    <?php if($per_comp >= 100){echo $req_comp . " Hours";}else{echo $page_total . " Hours";} ?>
					  </div>
					  <center><?php if($per_comp <= 100){echo $rem_comp . " Hours";} ?></center>
					</div>
					<h5>Hours Required to Letter: <b><?php echo $req_letter; ?> Hours</b><br>
					Your Progress: <?php echo $per_letter . "%"; ?></h5>
					<div class="progress">
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($per_letter >= 100){echo 100;}else{ echo $per_letter;} ?>%;">
					    <?php if($per_letter >= 100){echo $req_letter . " Hours";}else{echo $page_total . " Hours";} ?>
					  </div>
					  <center><?php if($per_letter <= 100){echo $rem_letter . " Hours";} ?></center>
					</div>
					If there are any errors please contact me!
					
			<?php } ?>
		</div>
				
				
	</body>
</html>