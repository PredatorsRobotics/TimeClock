<?php
	include_once('../config.php');
	$conn = mysqli_connect($servername, $username, $password, $database);
	session_start();
	
	if($_SESSION['ADMIN'] !== 1){
	  header('location: login.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />

    <link href="../css/dashboard.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $title; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">Home</a></li>
            <li class="active"><a href="index.php">Dashboard</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="login.php?logout=1">Log Out</a></li>
            <hr class="visible-xs">
            <li class="visible-xs active"><a href="index.php">Overview</a></li>
            <li class="visible-xs"><a href="users.php">Users</a></li>
            <li class="visible-xs"><a href="logs.php">Reports</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="index.php">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="logs.php">Reports</a></li>
          </ul>
        </div>
        <?php
        $result = mysqli_query($conn,"SELECT * FROM `$user_table`");
        $user_num = mysqli_num_rows($result);
        
        
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
          <h2 class="sub-header">Actions</h2>
          <a href="action.php?clockout=1" class="btn btn-primary">Clock All Users Out</a> <a href="logs.php?n=date&v=<?php echo date('Y-m-d'); ?>" class="btn btn-warning">Veiw Today's Report</a>
          <h2 class="sub-header">Statistics</h2>
          <div class="row placeholders">
              <?php
                //Total Hours
                $result = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE `Time_Out` IS NOT NULL AND Status=1");
      		      $loop_total = 0;
                while($row = mysqli_fetch_array($result)) {
                      $time_in = $row['Time_In'];
		                 	$time_out = $row['Time_Out'];
                      $total = ( ( strtotime($time_out) - strtotime($time_in) ) / 60 ) / 60;
                      $loop_total = $loop_total + $total;
                }
                $loop_total = number_format($loop_total, 1);
                
                //Total Users
                $result = mysqli_query($conn,"SELECT * FROM `$user_table`");
                $total_users = mysqli_num_rows($result);
                
                //Total Over Competition
                //Total Letter
                $result = mysqli_query($conn,"SELECT * FROM `$user_table` ORDER BY ID ASC");
		            
		            $total_comp = 0;
		            $total_letter = 0;
		            
                while($row = mysqli_fetch_array($result)) {
                    $comp = 0;
                    $user = $row['ID'];
                    $result2 = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE `User`='$user' AND `Time_Out` IS NOT NULL AND Status=1");
                    while($row2 = mysqli_fetch_array($result2)){
                      $time_in = $row2['Time_In'];
		                 	$time_out = $row2['Time_Out'];
                      $total = ( ( strtotime($time_out) - strtotime($time_in) ) / 60 ) / 60;
                      $comp = $comp + $total;
                    }
                    $comp = number_format($comp, 1);
                    if($comp >= $req_comp ){
                      if(strtotime($time_in) >= strtotime($build_start)){
                        if(strtotime($time_in) <= strtotime($build_end)){
                          $total_comp = $total_comp + 1;
                        }
                      }
                    }
                    
                    if($comp >= $req_letter){
                      if(strtotime($time_in) >= strtotime($build_start)){
                        if(strtotime($time_in) <= strtotime($build_end)){
                          $total_letter = $total_letter + 1;
                        }
                      }
                    }
                }
                
                
                
              ?>
              <div class="col-xs-6 col-sm-3 placeholder">
                <span style="font-size: 5em;"><?php echo $loop_total; ?></span>
                <h4>Total Hours</h4>
              </div>
              <div class="col-xs-6 col-sm-3 placeholder">
                <span style="font-size: 5em;"><?php echo $total_users; ?></span>
                <h4>Total Students</h4>
              </div>
              <div class="col-xs-6 col-sm-3 placeholder">
                <span style="font-size: 5em;"><?php echo $total_comp; ?></span>
                <h4>Students Competing</h4>
              </div>
              <div class="col-xs-6 col-sm-3 placeholder">
                <span style="font-size: 5em;"><?php echo $total_letter; ?></span>
                <h4>Students Lettered</h4>
              </div>
            </div>
          <h2 class="sub-header">Students Clocked In <a href="action.php?clockout=1" class="btn btn-primary">Clock All Out</a></h2>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Duration</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE `Time_Out` IS NULL");
    		
              while($row = mysqli_fetch_array($result)) {
                $Time_In = $row['Time_In'];
                $current_time = date('Y-m-d H:i:s');
                $minutes = (strtotime($current_time) - strtotime($Time_In)) /60;
                $round_minutes =  number_format($minutes, 1);
                if($minutes < 60){
                  $duration = $round_minutes;
                  $label = "Minutes";
                }else{
                  $hours = $minutes /60;
                  $round_hours =  number_format($hours, 1);
                  $duration = $round_hours;
                  $label = "Hours";
                }
                $userID = $row['User'];
                $name = mysqli_query($conn,"SELECT * FROM `$user_table` WHERE ID=$userID");
                while($namesrow = mysqli_fetch_array($name)) {
                  $userNAME = $namesrow['Name'];
                }
                echo "<tr>";
                echo "<td>" . $userNAME . "</td>";
                echo "<td>" . $duration . " " . $label . "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
          <h2 class="sub-header">Recent Actions</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $result = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE Time_Out IS NOT NULL ORDER BY ID DESC LIMIT 5");
		
                while($row = mysqli_fetch_array($result)) {
                    $time_in = $row['Time_In'];
                    $time_out = $row['Time_Out'];
                    
                    switch ($row['Status']) {
                        case 0:
                            $status = '<span class="label label-warning">Pending</span>';
                            break;
                        case 1:
                            $status = '<span class="label label-success">Approved</span>';
                            break;
                        case 2:
                            $status = '<span class="label label-danger">Denied</span>';
                            break;
                    }
                    
                    echo "<a href='logs.php?n=id&v=" . $row['ID'] . "'><tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<a href='logs.php?n=id&v=" . $row['ID'] . "'><td>" . $row['User'] . "</td></a>";
                		echo "<td>" . date('l, F j, Y', strtotime($time_in)) . "</td>";
                    echo "<td>" . date("g:i A", strtotime($time_in)) . "</td>";
                    echo "<td>" . date("g:i A", strtotime($time_out)) . "</td>";
                    echo "<td><a href='logs.php?n=id&v=" . $row['ID'] . "'>" . $status . "</a></td>";
                    echo "</tr></a>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>  
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
