<?php

if(isset($_POST['timezone'])){
  
  $timezone = $_POST['timezone'];
  
  $servername = $_POST['servername'];
  
  $username = $_POST['username'];
  
  $password = $_POST['password'];
  
  $database = $_POST['database'];
  
  $user_table = $_POST['user_table'];
  
  $data_table = $_POST['data_table'];
  
  $title = $_POST['title'];
  
  $req_comp = $_POST['req_comp'];
  
  $req_letter = $_POST['req_letter'];
  
  $config = '<?php
	$timezone = "' . $timezone . '";

	// Database Information
	$servername = "' . $servername . '";
	$username = "' . $username . '";
	$password = "' . $password . '";
	$database = "' . $database . '";
	
	$user_table = "' . $user_table . '";
	$data_table = "' . $data_table . '";
	
	$title = "' . $title . '";
	$req_comp = ' . $req_comp . '; //Hours required for competition
	$req_letter = ' . $req_letter . '; //Hours required to letter
?>';

  /* Write Variables to file */
  $fp = fopen("../config.php", "w");
  fwrite($fp, $config);
  fclose($fp);
  
  header( "refresh:0");
  
}else{
  include("../config.php");
}


?>
<html>
  <head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/timeclock.css"
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $title; ?></title>
  </head>
  <body>
    <div class="visible-xs visible-sm"></div>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Dash</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">Display</a></li>
            <li><a href="index.php">Matches</a></li>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 col-md-12 main">
          <h1 class="page-header">Settings</h1>
		        <div class="table-responsive">
              <table class="table table-striped">
		    	      <thead>
                  <tr>
                    <th>Data</th>
                    <th>Value</th>
                  </tr>
                </thead>
                <form method="post" action="">
                  <tbody>
                    <tr>
                      <td>Time Zone</td>
                      <td><input type="text" name="timezone" value="<?php echo $timezone; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                      <td>Title</td>
                      <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                      <td>Competition Requirement</td>
                      <td><input type="text" name="req_comp" value="<?php echo $req_comp; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                      <td>Letter Requirement</td>
                      <td><input type="text" name="req_letter" value="<?php echo $req_letter; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                                        <tr>
                      <td>Server Name</td>
                      <td><input type="text" name="servername" value="<?php echo $servername; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                      <td>Username</td>
                      <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                      <td>Password</td>
                      <td><input type="text" name="password" value="<?php echo $password; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                      <td>Database</td>
                      <td><input type="text" name="database" value="<?php echo $database; ?>"></td>
                      <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                        <td>User Table</td>
                        <td><input type="text" name="user_table" value="<?php echo $user_table; ?>"></td>
                        <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                    <tr>
                        <td>Data Table</td>
                        <td><input type="text" name="data_table" value="<?php echo $data_table; ?>"></td>
                        <td><input type="submit" class='btn btn-default'/></td>
                    </tr>
                  </tbody>
                </form>
              </table>
            </div>
          </h1>
        </div>
      </div>
    </div>
  </body>
</html>