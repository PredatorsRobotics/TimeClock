<?php
	include_once('../config.php');
	$conn = mysqli_connect($servername, $username, $password, $database);
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
        $result = mysqli_query($conn,"SELECT * FROM `users`");
        $user_num = mysqli_num_rows($result);
        
        
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
          <h2 class="sub-header">Students Clocked In</h2>
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
                echo "<tr>";
                echo "<td>" . $row['User'] . "</td>";
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
              $result = mysqli_query($conn,"SELECT * FROM `hours` ORDER BY ID DESC LIMIT 5");
		
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
                    
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['User'] . "</td>";
                		echo "<td>" . date('l, F j, Y', strtotime($time_in)) . "</td>";
                    echo "<td>" . date("g:i A", strtotime($time_in)) . "</td>";
                    echo "<td>" . date("g:i A", strtotime($time_out)) . "</td>";
                    echo "<td>" . $status . "</td>";
                    echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </body>
</html>
