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
    $PIN = $_POST['PIN'];
    $sql = "INSERT INTO `$user_table` (username, Name, pin) VALUES ('$Username', '$Name', '$PIN')";
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
?>