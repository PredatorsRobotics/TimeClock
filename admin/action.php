<?php

include_once('../config.php');

$conn = mysqli_connect($servername, $username, $password, $database);

if(isset($_GET['d'])){
    $user = $_GET['d'];
    $sql = "DELETE FROM `$user_table` WHERE `ID` ='$user'";
    $conn->query($sql);
    header('Location: users.php');
    die;
}

?>