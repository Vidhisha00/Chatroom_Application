<?php 
include 'connect.php';
$username=$_POST['username'];
$roomId=$_POST['id'];
$sql="SELECT * FROM `user_room` WHERE `user` = '$username' AND `room` = '$roomId';";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
    echo $row['status'];
}

?>