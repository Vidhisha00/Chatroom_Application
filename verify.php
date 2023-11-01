<?php
    session_start();
    include 'connect.php';
    $code=$_GET['code'];
    $email=$_GET['email'];
    $sql="SELECT * FROM `accounts` WHERE `email`='$email';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        if($row['code']==$code){
            $sql="UPDATE `accounts` SET `status` = '1' WHERE `email`='$email';"; 
            $result=mysqli_query($conn,$sql);
            $_SESSION['username']=$row['username'];
            $_SESSION['signing_up']='yes';
            header("Location:home.php");
        }
    }

?>