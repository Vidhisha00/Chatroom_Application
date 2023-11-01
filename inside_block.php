<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
 
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <style>
        /* Added some styles to improve the look of the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        #header {
            background-color: #303030;
            color: white;
            padding: 10px;
            text-align: center;
        }
        #chat-container {
            background-color: white;
            margin: auto;
            margin-top: 20px;
            width: 70%;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #bbb;
            padding: 20px;
        }
        #chat-messages {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color:#E8E8E8;
        }
        #send-message-form {
            display: flex;
            flex-direction: row;
            margin-top: 10px;
        }
        #message-text {
            flex-grow: 1;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }
        #send-button {
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        
        .popover-header{
            max-width:300px;
            max-height:300px;
        }
        .avatarimg{
            max-width:150px;
            max-height:150px;
        }
        
        #send-button:hover {
            background-color: #444;
            border-color:-internal-light-dark(rgb(118, 118, 118), rgb(133, 133, 133));
        }

        #myButton{
            margin:20px;
            background-color: #333;
            border-color: #333;
            border-radius:7px;
        }

        #myButton:hover{
            margin:20px;
            background-color: #495057;
            border-color: #495057;
            border-radius:7px;
        }


        #sendd {
  background-color: white;
  border: none;
}
#sendd {
  display: block;
  width: 100%;
  height: auto;
  
}
    #usersbtn{
        color:black;
        margin:50px;
    }
        
    </style>
    <?php
    include 'connect.php';
    session_start();
    $admin="";
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
        $roomId=$_SESSION['roomcode'];
        $sql="SELECT * FROM `rooms` WHERE `roomcode`='$roomId'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $roomname="";
            while($row=mysqli_fetch_assoc($result)){
                $admin=$row['admin'];
                $roomname=$row['roomname'];
            }
        }
        else{
            header("Location:home.php");
        }
    }
    else{
        header("Location:home.php");
    }
?>

    <script>
    $(document).ready(function() {
        
    // Initialize the last timestamp to the current time
        var lastTimestamp = 0;
        var lastTimestamp2=0;
        // Retrieve the chat room ID and username from the URL
        var roomId = "<?php echo $roomId;?>";
        var username = "<?php echo $username; ?>";
        var roomname="<?php echo $roomname; ?>";
        var admin="<?php echo $admin;?>";
        // Display the chat room ID and username
        $("#room-id").text("Room ID: " + roomId);
        $("#username").text("Username: " + username);
        $("#roomname").text(roomname);
      
     
        setInterval(function() {
            $.ajax({
                type:"POST",
                url:"check_user_status.php",
                data:{id:roomId,username:username},
                datatype:"json",
                success:function(response){
                    console.log(response);
                    if(response==0){
                        window.location.href='inside.php';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }, 1000); 
        
    });
    
    </script>
</head>
<body>
    <div id="header">
        <h2 id="roomname"></h2>
        <div id="room-id"></div>
        <div id="username"></div>
    </div>    
    <p>You have been blocked from the room by admin. Stay on this page and will redirect you back to the room if admin unblocks you.</p>
    
    
    
    
</body>
</html>