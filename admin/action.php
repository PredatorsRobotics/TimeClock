<?php

include_once('../config.php');

$conn = mysqli_connect($servername, $username, $password, $database);

//DELETE USER
if(isset($_GET['d'])){
    $user = $_GET['d'];
    $sql = "DELETE FROM `$user_table` WHERE `ID` ='$user'";
    $conn->query($sql);
    header('Location: users.php');
    die;
}

//CREATE USER
if(isset($_POST['Name'])){
    $Name = $_POST['Name'];
    $Username = $_POST['Username'];
    $sql = "INSERT INTO `$user_table` (username, Name) VALUES ('$Username', '$Name')";
    $conn->query($sql);
    header('Location: users.php');
    die;
}

//CHANGE HOUR STATUS
if(isset($_GET['s'])){
    $status = $_GET['s'];
    $id = $_GET['id'];
    $n = $_GET['n'];
    $v = $_GET['v'];
    $sql = "UPDATE `$data_table` SET status='$status' WHERE ID='$id'";
    $conn->query($sql);
    header('Location: logs.php?n=' . $n . '&v=' . $v);
    die;
}

//DELETE HOURS
if(isset($_GET['dh'])){
    $hours = $_GET['id'];
    $n = $_GET['n'];
    $v = $_GET['v'];
    $sql = "DELETE FROM `$data_table` WHERE `ID` ='$hours'";
    $conn->query($sql);
    header('Location: logs.php?n=' . $n . '&v=' . $v);
    die;
}

//CLOCK OUT ALL USERS
if(isset($_GET['clockout'])){
    $time = date('Y-m-d H:i:s');
    $sql = "UPDATE `$data_table` SET Time_Out='$time' WHERE Time_Out IS NULL";
    $conn->query($sql);
    header('Location: index.php');
    die;
}

//RESETS PASSWORD
if(isset($_GET['password'])){
    $password = $_GET['password'];
    $sql = "UPDATE `$user_table` SET pin = NULL WHERE ID='$password'";
    $conn->query($sql);
    header('Location: users.php');
    die;
}

?>