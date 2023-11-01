<?php
include 'connect.php';
$roomId=$_POST['roomId'];
$username=$_POST['username'];
$sql = "DROP TABLE `$roomId`;";
$result=mysqli_query($conn, $sql);
$sql = "DELETE FROM `rooms` WHERE `roomcode` = '$roomId'";
$result=mysqli_query($conn, $sql);
$sql="DELETE FROM `user_room` WHERE `room` = '$roomId'";
$result=mysqli_query($conn,$sql);
?>