<?php 
    include 'connect.php';
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $roomcode=$_POST['roomcode'];
        $roomname='';
        $username=$_SESSION['username'];
        $sql="SELECT * FROM `rooms` WHERE `roomcode` = '$roomcode';";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row= mysqli_fetch_assoc($result)){
                $roomname=$row['roomname'];
            }
            $_SESSION['roomcode']=$roomcode;
            $_SESSION['roomname']=$roomname;
            $sql="SELECT * FROM `user_room` WHERE `user`='$username' AND `room`='$roomcode';";
            $result=mysqli_query($conn,$sql);

            if(mysqli_num_rows($result)==0){
                $sql="INSERT INTO `user_room` (`user`, `room`, `status`) VALUES ('$username', '$roomcode', '0');";
                $result=mysqli_query($conn,$sql);
            }
            else{
                $row=mysqli_fetch_assoc($result);
                if($row['status']!=0){
                    //header("Location:home.php");
                    exit();
                }
            }
            header("Location:inside.php");
        }
        else{
            $_SESSION['s_cnt']=1;
            header("Location:home.php");
        }
    }
    
    else{
        //redirect to login or signup
        $_SESSION['s_cnt']=2;
        header("Location:home.php");
    }
?>
