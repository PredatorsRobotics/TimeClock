<?php
	include_once('config.php');
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <style type="text/css">
            .error {
                color: #ff0000;
            }
        </style>
    </head>
    <body>
        <h2>Robotics Team Sign-In</h2>
        <p>Looking to check your hours? Click <a href="getloghours.php">here</a></p>
        <h3 style="color:#FF0000;">Important: Log hours in 24hr format!<br/>
        Example: 3:00 PM translates to 15:00 and <br/>9:00 AM translates to 09:00</h3>
        <p><span class="error">* required field.</span></p>
        <form method="post" action="index.php">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" required /><span class="error">* </span></td>
            </tr>
            <tr>
                <td>Time In:</td>
                <td><input type="text" name="time_in" required /><span class="error">* </span></td>
            </tr>
            <tr></tr>   
                <td>Time Out:</td>
                <td><input type="text" name="time_out" required /><span class="error">* </span></td>
            </tr>
            <tr>
                <td><input type="submit"/></td>
            </tr>
        </table>
        <?php 
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        if(isset($_POST['name'])) {
            $name = $_POST['name'];
            $time_in = $_POST['time_in'];
            $time_out = $_POST['time_out'];
            $date = date('Y-m-d');
            
            $sql = "INSERT INTO `hours` (`User`, `Date`, `Time_In`, `Time_Out`) VALUES ('" . $name . "', '" . $date . "', '" . $time_in . "', '" . $time_out . "')";
            
            $conn->query($sql);
            
            echo "<h2>Hours logged:</h2><br>";
            echo $name . "<br>";
            echo $time_in . "<br>";
            echo $time_out;
        }


        
        ?>
    </body>
</html>