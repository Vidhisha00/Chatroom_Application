<?php 
session_start();
include 'connect.php';
$username=$_POST['username'];
$roomId=$_POST['roomId'];
echo $username;
echo $roomId;
$sql="SELECT * FROM `user_room` WHERE `user` = '$username' AND `room` = '$roomId';";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
    if($row['status']==1){
        $sql="UPDATE `user_room` SET `status` = '0' WHERE `user` = '$username' AND `room` = '$roomId';";
        $result=mysqli_query($conn,$sql);
    }
    else{
        $sql="UPDATE `user_room` SET `status` = '1' WHERE `user` = '$username' AND `room` = '$roomId';";
        $result=mysqli_query($conn,$sql);
    }
}

?>