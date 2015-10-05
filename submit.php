<?php

include_once('config.php');
$conn = mysqli_connect($servername, $username, $password, $database);

switch ($_POST['function']) {
    case 'getIsClockedIn':
        $username = $_POST['username'];
        
        $user_var = mysqli_query($conn,"SELECT * FROM `$user_table` WHERE `Name`='$username' OR `username`='$username'");
        $value = mysqli_num_rows($user_var);
        if($value==0){
            die("-1");
        }
        
        $result = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE User='$username' AND Time_Out IS NULL");
        $value = mysqli_num_rows($result);
        echo $value;
        break;
    case 'getIsManual':
        $username = $_POST['username'];
        
        $user_var = mysqli_query($conn,"SELECT * FROM `$user_table` WHERE `Name`='$username' OR `username`='$username'");
        $value = mysqli_num_rows($user_var);
        if($value==0){
            die("-1");
        }
        
        $result = mysqli_query($conn,"SELECT * FROM `$data_table` WHERE User='$username' AND Time_Out IS NULL");
        $value = mysqli_num_rows($result);
        echo $value;
        break;
    case 2:
        echo "i equals 2";
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['name'])) {
    $name = $_POST['name'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $date = date('Y-m-d');
    
    $sql = "INSERT INTO `$data_table` (`User`, `Date`, `Time_In`, `Time_Out`) VALUES ('" . $name . "', '" . $date . "', '" . $time_in . "', '" . $time_out . "')";
    
    $conn->query($sql);
    
    echo "<h2>Hours logged:</h2><br>";
    echo $name . "<br>";
    echo $time_in . "<br>";
    echo $time_out;
}
?>