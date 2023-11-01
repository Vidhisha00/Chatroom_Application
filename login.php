<?php include('connect.php');
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST['username2'];
        $password=$_POST['password2'];
        
        $sql="SELECT * FROM `accounts` WHERE `username` = '$username'";

        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==0){
            //username doesnt exist
          
        }
        else{

            while ($row = mysqli_fetch_assoc($result)) {
                
                if ($password==$row['password']) {
                    session_start();
                    $_SESSION['username']=$username;
                    header("Location:home.php");
                } else {
                    //password is incorrect
                }
            }
           
        }
          
    }
?>