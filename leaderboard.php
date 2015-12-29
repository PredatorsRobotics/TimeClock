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
	            <li><a href="index.php">Clock In/Out</a></li>
	            <li><a href="manualhours.php">Manual Entry</a></li>
	            <li><a href="getloghours.php">Check Hours</a></li>
	            <li class="active"><a href="leaderboard.php">Leaderboard</a></li>
	            <li><a href="admin">Admin</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>
    <div class="container">
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading"><?php echo $title; ?><br>Leaderboard</h2>
        <center><div class="btn-group" role="group" aria-label="...">
          <a href="?" class="btn btn-default <?php if($_GET['t']!=t){echo 'active';} ?>">Competition</a>
          <a href="?t=t" class="btn btn-default <?php if($_GET['t']==t){echo 'active';} ?>">Total</a>
        </div></center>
        <br>
        <table class="table">
          <thead>
              <tr>
                  <td>Place</td>
                  <td>Name</td>
                  <td>Hours</td>
              </tr>
          </thead>
          <tbody>
              <?php
              $result = mysqli_query($conn,"SELECT * FROM `$user_table` ORDER BY ID ASC");
              $leader = array();
              
              $build_start_date = strtotime($build_start);
		          $build_end_date = strtotime($build_end);
		                
              while($row = mysqli_fetch_array($result)) {
                    $loop_total = 0;
                    $user = $row['Name'];
                    $user_id = $row['ID'];
                    $result2 = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE `User`='$user_id' AND `Time_Out` IS NOT NULL AND Status=1");
                    while($row2 = mysqli_fetch_array($result2)){
                      $time_in = $row2['Time_In'];
		                 	$time_out = $row2['Time_Out'];
                      $total = ( ( strtotime($time_out) - strtotime($time_in) ) / 60 ) / 60;
                      
                      if($_GET['t']!=t){
                      if(strtotime($time_in) >= $build_start_date){
                        if(strtotime($time_in) <= $build_end_date){
                          $loop_total = $loop_total + $total;
                        }
                      }
                      }else{
                        $loop_total = $loop_total + $total;
                      }
                      
                    }
                    $loop_total = number_format($loop_total, 1);
                    if($loop_total != 0.0){
                      $leader[$user] = $loop_total;
                    }
              }
              
              arsort($leader);
              $id = 1;

              foreach($leader as $x => $x_value) {
                   echo "<tr>";
                   echo "<td>" . $id . "</td>";
                   echo "<td>" . $x . "</td>";
                   echo "<td>" . $x_value . "</td>";
                   echo "</tr>";
                   
                   $id ++;
              }
              ?>

          </tbody>
        </table>
      </form>
    </div>
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>