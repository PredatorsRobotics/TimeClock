<?php
	include_once('config.php');
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
		<style>
		.error {color: #FF0000;}
		</style>
	</head>
<body>
<h2>Robotics Hour Checker</h2>
<p>Looking to log your hours? Click <a href="index.php">here</a></p>
<p><span class="error">* required field.</span></p>
<form method="post" action="getloghours.php">
Student Name:   
<span class="error">* </span>
<input type="text" name="name" value=""> <span class="error"></span>
<br/>
<br/>
<input type="submit" name="submit" value="Submit">
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
	</body>
</html>