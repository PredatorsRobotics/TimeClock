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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#add").click(function(){
            $("#add_button").hide(200, function(){
              $("#add_user").show(200); 
            });
        });
    });
    </script>
    <style>
      #add_user{
        display: none;
      }
    </style>
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
            <li><a href="index.php">Overview <span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="users.php">Users</a></li>
            <li><a href="logs.php">Reports</a></li>
          </ul>
        </div>
        <?php
        $result = mysqli_query($conn,"SELECT * FROM `users`");
        $user_num = mysqli_num_rows($result);
        
        
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <h2 class="sub-header">Users</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>PIN</th>
                  <th>Hours</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $result = mysqli_query($conn,"SELECT * FROM `users` ORDER BY ID ASC");
		
                while($row = mysqli_fetch_array($result)) {
                    $loop_total = 0;
                    $user = $row['Name'];
                    $result2 = mysqli_query($conn,"SELECT * FROM `hours` WHERE `User`='$user' AND `Time_Out` IS NOT NULL");
                    while($row2 = mysqli_fetch_array($result2)){
                      $time_in = $row2['Time_In'];
		                 	$time_out = $row2['Time_Out'];
                      $total = ( ( strtotime($time_out) - strtotime($time_in) ) / 60 ) / 60;
                      $loop_total = $loop_total + $total;
                    }
                    $loop_total = number_format($loop_total, 1);
                    $id = $row['ID'];
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo '<td><a href="logs.php?n=name&v=' . $user . '">' . $user . '</a></td>';
                	echo "<td>" . $row['username'] . "</td>";
                    echo "<td>****</td>";
                    echo "<td>" . $loop_total . "</td>";
                    if($row['admin'] == 1)
                    {
                        $admin = '<span class="label label-default">Admin</span>';
                    }else{
                        $admin = '';
                    }
                    echo '<td> <a class="label label-warning">Edit</a> <a href="action.php?d=' . $id . '" class="label label-danger">Delete</a> ' . $admin . "</td>";
                    echo "</tr>";
                }
                ?>
                <tr id="add_button">
                    <td colspan="6"><a id="add" class="label label-success">Add+</a></td>
                </tr>
                <tr id="add_user">
                    <form method="post" action="action.php">
                      <td></td>
                      <td><input type="text" name="Name"></td>
                      <td><input type="text" name="Username"></td>
                      <td><input type="tel" name="PIN" id="inputPassword" style="-webkit-text-security: disc;" maxlength="4" autocomplete="off"></td>
                      <td></td>
                      <td><button type="submit" class="label label-success">Add</button></td>
                    </form>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>