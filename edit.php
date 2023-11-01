<?php 
session_start();
include 'connect.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_SESSION['username'];
    $new_username=$_POST['username'];
    $new_password=$_POST['password'];
    $sql="SELECT * FROM `accounts` WHERE `username` = '$new_username';";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0 && $username!=$new_username){
        
        $_SESSION['s_cnt']=5;
        header("Location:home.php");
    }
    else{
        if ($new_password!="" && !preg_match('/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%^&*(),.?":{}|<>]{8,20}$/', 
            $new_password)){
            $_SESSION['s_cnt']=6;
            header("Location:home.php");
        }
        else{
        $sql="SELECT * FROM `accounts` WHERE `username`='$username';";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        if($new_password=="")$new_password=$row['password'];
        $sql="DELETE FROM `accounts` WHERE `username` = '$username';";
            
        $result=mysqli_query($conn,$sql);
        $email=$row['email'];
        $code=$row['code'];
        $sql="INSERT INTO `accounts` (`username`, `password`,`email`,`code`,`status`) VALUES 
        ('$new_username', '$new_password','$email','$code','1');";
                
        $result=mysqli_query($conn,$sql);
    
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];
         
        // Check if there was no error during the upload
        if ($fileError === 0) {
            // Set the destination folder
            $uploadDir = 'uploads/';
            // Generate a unique name for the file
            $fileNewName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            // Set the destination path
            $uploadPath = $uploadDir . $fileNewName;

            // Move the uploaded file to the destination folder
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $sql="DELETE FROM `profile pictures` WHERE `username` = '$username';";
                $result=mysqli_query($conn,$sql);
                $sql="INSERT INTO `profile pictures` (`username`, `profilepic`) VALUES ('$new_username', '$uploadPath');";
                $result=mysqli_query($conn,$sql);
            } 
            else{
                $sql="UPDATE `profile pictures` SET `username` = '$new_username' WHERE `username` = '$username';";
                $result1=mysqli_query($conn,$sql);
            }
        }
        
        else{
            $sql="UPDATE `profile pictures` SET `username` = '$new_username' WHERE `username` = '$username';";
            $result1=mysqli_query($conn,$sql);
        }
        
    
        $sql="SELECT * FROM `rooms` WHERE `admin`='$username'";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
            $row_roomcode=$row['roomcode'];
            $sql="UPDATE `rooms` SET `admin` = '$new_username' WHERE `roomcode` = '$row_roomcode';";
            $result1=mysqli_query($conn,$sql);
        }

        $_SESSION['username']=$new_username;
        $sql="SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = 'chatroom'
        AND table_name NOT IN ('accounts', 'rooms', 'profile pictures','user_room');
        ";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                $sql="UPDATE `{$row['table_name']}` SET `sender_name` = '$new_username' WHERE `sender_name` = '$username';";
                $result1=mysqli_query($conn,$sql);
            }
        }

        $sql="UPDATE `user_room` SET `user` = '$new_username' WHERE `user` = '$username';";
        $result=mysqli_query($conn,$sql);
        $_SESSION['s_cnt']=20;
        header("Location:home.php");
    }
        

    }

}

?>