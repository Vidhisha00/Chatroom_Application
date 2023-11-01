<?php 
    include 'connect.php';
    include 'delete_db.php';
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
     
        $roomcode='';
        $cnt=0;

        while(1){
            if($cnt==26*26*26*26){
                $_SESSION['s_cnt']=3;
                header("Location:home.php");
            }
            $cnt++;
            $letters = 'abcdefghijklmnopqrstuvwxyz';
            $code = '';

            for ($i = 0; $i < 4; $i++) {
                $index = rand(0, strlen($letters) - 1);
                $code .= $letters[$index];
            }
            $sql="SELECT * FROM `rooms` WHERE `roomcode` = '$code'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                continue;
            }
            else{
                $roomcode=$code;
                break;
            }
        } 
        $roomname=$_POST['roomname'];
        $username=$_POST['username'];
        $roomname = mysqli_real_escape_string($conn, $roomname);
        
        $sql="INSERT INTO `rooms` (`roomcode`, `roomname`,`admin`) VALUES ('$roomcode','$roomname','$username');";
        
        $result=mysqli_query($conn,$sql);
        
        if($result){
            $sql="CREATE TABLE $roomcode (
                id INT(11) NOT NULL AUTO_INCREMENT,
                sender_name VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                sent_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
                );";
            $result=mysqli_query($conn,$sql);
            if($result){
                $_SESSION['roomname']=$roomname;
                $_SESSION['roomcode']=$roomcode;
                $_SESSION['username']=$username;
                $sql="INSERT INTO `user_room` (`user`, `room`, `status`) VALUES ('$username', '$roomcode', '0');";
                $result=mysqli_query($conn,$sql);
                header("Location:inside.php");
            }
            
            else{
                $_SESSION['s_cnt']=4;
                header("Location:home.php");
            }
        }
        else{
            $_SESSION['s_cnt']=4;
            header("Location:home.php");
        }
    }

    else{
        $_SESSION['s_cnt']=2;
        header("Location:home.php");
       
    }
?>