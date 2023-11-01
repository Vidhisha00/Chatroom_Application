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
            /* margin-top: 10px; */
        }
        #message-text {
            flex-grow: 1;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }
        #send-button {
            /* background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: none; */
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
            /* background-color: #444;
            border-color:-internal-light-dark(rgb(118, 118, 118), rgb(133, 133, 133)); */
        }

        #myButton,#viewusersbtn{
            background-color: #333;
            border-color: #333;
            border-radius:7px;
        }
        #viewusersbtn{
            margin-top:20px;
        }

        #myButton:hover{
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
            if(username!=admin){
                $.ajax({
                    type:"POST",
                    url:"check_user_status.php",
                    data:{id:roomId,username:username},
                    datatype:"json",
                    success:function(response){
                        console.log(response);
                        if(response==1){
                            window.location.href='inside_block.php';
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle any errors here
                        console.log(errorThrown);
                    }


                });
            }
            $.ajax({
                type: "POST",
                url: "get_users.php",
                data: {id: roomId},
                dataType: "json",
                success: function(data){
                    var maxtimestamp=0;
                    console.log(data);
                    console.log("hello");
                    for(var i in data){
                        var user=data[i];
                        var timestamp = Date.parse(user.timestamp);
                        if(maxtimestamp<timestamp)maxtimestamp=timestamp;
                        if(timestamp<=lastTimestamp2)continue;
                        var userdiv= $("<div>");
                        var usernamee=$("<p>");
                        usernamee.text(user.username);
                        console.log(user.username);
                        var profilepic=$("<img src='" + user.path + "'>");
                        var tmp=user.username;
                        if(admin!=user.username && admin==username){
                            console.log(user.username);
                            var blockBtn ;
                            if(user.blocked==0)blockBtn= $("<button>").addClass("btn btn-primary").text("Block");
                            else blockBtn=$("<button>").addClass("btn btn-primary").text("Unblock");
                            blockBtn.click(function() {
                                var btnText = $(this).text();
                              
                                // Toggle the text content of the button element
                                if (btnText === "Block") {
                                    $(this).text("Unblock");
                                } else {
                                    $(this).text("Block");
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "change_status.php",
                                    data: { roomId:roomId,username: tmp },
                                    success: function(response) {
                                        // Handle the server response here
                                        console.log("heyyy");
                                        console.log(response);
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        // Handle any errors here
                                        console.log(errorThrown);
                                    }
                                });
                            });

                            userdiv.append(profilepic, usernamee, blockBtn);
                            
                        blockBtn.css( {
                        'background-color': 'black',
                        'color':' white',
                        'border': 'none',
                        'padding': '10px 20px',
                        'border-radius': '5px',
                        'cursor': 'pointer'
                        });
                        }
                        else userdiv.append(profilepic, usernamee);
                        $('#usersdiv').append(userdiv);
                        userdiv.css({
                            'margin':'20px',
                            'display':'flex',
                            'align-items': 'center',
                            'height':'100px',
                            'padding': '10px',
                            'border': '1px solid #ccc'
                        });
                        
                        profilepic.css( {
                        'width': '50px',
                        'height': '50px',
                        'border-radius': '50%',
                        'margin-right': '10px'
                        });

                        usernamee.css( {
                        'font-size': '18px',
                        'font-weight': 'bold',
                        'margin-right': 'auto'
                        });
                                        
                    }

                    if(maxtimestamp>lastTimestamp2)lastTimestamp2 = maxtimestamp;
                    console.log(lastTimestamp2);
                    console.log(maxtimestamp);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors here
                    console.log(errorThrown);
                }
            });
            $.ajax({
                type: "POST",
                url: "refresh.php",
                data: {id: roomId , lastTimeStamp:lastTimestamp, username: username},
                dataType: "json",
                success: function(data) {
                    // Add each new chat message to the display
                    for (var i in data) {
                        var message = data[i];
                        var timestamp = Date.parse(message.timestamp);
                        
                        if (timestamp > lastTimestamp) {
                            if(message.f==0){
                                var date = new Date(timestamp);
                                var hours = date.getHours();
                                var minutes = date.getMinutes();
                                

                                // Create a human-readable timestamp string
                                var humanTimestamp = hours + ":" + (minutes < 10 ? '0' : '') + minutes;

                            
                                if (message.path) {
                                // Create an image element and set its source to the path of the image on the server
                                var image = $("<img src='" + message.path + "'>");
                                // Set the CSS properties of the image element
                                image.css({
                                    'width': '40px',
                                    'height': '40px',
                                    'border-radius': '50%',
                                    'margin-right': '10px'
                                });
                                // Append the image element to the new message element
                                
                                // Create a new message element and append the image element to it
                                var newMessage = $("<div>").append(image);
                                newMessage.css({
                                    'display': 'flex',
                                    'align-items': 'center',
                                    'height':'50px',
                                    'clear':'both'
                                });
                                }const content = `
                                <div class="popover">
                                    <div class="popover-header" style="align-items: center;">
                                        <div class="avatar" style="margin-right: 10px;">
                                            <img class="avatarimg" src="${message.path}">
                                        </div>
                                        <div class="name" style="display: inline-block;">${message.sender_name}</div>
                                    </div>
                                    
                                </div>
                            `;
                                image.popover({
                                    trigger: 'hover',
                                    placement: 'top',
                                    content: content
                                });

                                // Create a container element to hold the username, timestamp, and message
                                var messageContainer = $("<div>");
                                // Set the CSS properties of the message container
                                messageContainer.css({
                                'display': 'flex',
                                'align-items': 'center'
                                });
                                // Append the message container to the new message element
                                newMessage.append(messageContainer);

                                // Create a username element and set its text to the sender's name
                                
                                // Create a message element and set its text to the sender's message
                                var messageElement = $("<div>").text(message.message);
                                // Append the message element to the message container
                                messageElement.css ({
                                    'background-color': '#FFFFFF',
                                    'padding': '10px',
                                    'border-radius': '10px',
                                    'border-color':'white',
                                    // 'border-shadow':
                                    'border':'0px solid',
                                    'color':'black',
                                    'display': 'inline-block',
                                    'margin-right': '5px'
                                });
                                messageContainer.append(messageElement);
                                // Create a timestamp element and set its text to the human-readable timestamp
                                
                                var timestampElement = $("<sub>").text(humanTimestamp);
                                timestampElement.css({
                                    'font-size': '0.8em',
                                    'margin-left': '5px'
                                });
                                // Append the subscript element to the message element
                                messageElement.append(timestampElement);
                                
                                
                                $("#chat-messages").append(newMessage);
                                $("#chat-messages").scrollTop($("#chat-messages")[0].scrollHeight);
                            }
                            else{
                                var date = new Date(timestamp);
                                var hours = date.getHours();
                                var minutes = date.getMinutes();
                                

                                // Create a human-readable timestamp string
                                var humanTimestamp = hours + ":" + (minutes < 10 ? '0' : '') + minutes;

                                var messageContainer = $("<div>");
                                messageContainer.css({
                                'display': 'flex',
                                'align-items': 'center'
                                });
                                
                                var messageElement = $("<div>");
                                // Append the subscript element to the message element
                                
                                // Set the CSS properties of the message container
                                var timestampElement = $("<sub>").text(humanTimestamp);
                                timestampElement.css({
                                    'font-size': '0.8em',
                                    'margin-left': '5px'
                                });
                                // Append the message container to the new message element
                                messageElement.text(message.message);
                                messageElement.append(timestampElement);
                                // Append the message element to the message container
                                messageElement.css ({
                                    'background-color': '#303030',
                                    'padding': '10px',
                                    'border-radius': '10px',
                                    'color':'white',
                                    'display': 'inline-block',
                                    'margin-right': '5px'
                                });
                                messageContainer.append(messageElement);      
                                var newMessage = $("<div>").append(messageContainer);
                                
                                
                                // Create an image element and set its source to the path of the image on the server
                                var image = $("<img src='" + message.path + "'>");
                                // Set the CSS properties of the image element
                                image.css({
                                    'width': '40px',
                                    'height': '40px',
                                    'border-radius': '50%',
                                    'margin-right': '10px'
                                });
                                
                                // Append the image element to the new message element
                                
                                // Create a new message element and append the image element to it
                                newMessage.append(image);
                                // Add the popover to the image element
                                const content = `
                                <div class="popover">
                                    <div class="popover-header" style="align-items: center;">
                                        <div class="avatar" style="margin-right: 10px;">
                                            <img class="avatarimg" src="${message.path}">
                                        </div>
                                        <div class="name" style="display: inline-block;">${message.sender_name}</div>
                                    </div>
                                    
                                </div>
                            `;

                            image.popover({
                                trigger: 'hover',
                                placement: 'right',
                                html: true,
                                content: content
                            });

                                
                                newMessage.css({
                                    'display': 'flex',
                                    'align-items': 'center',
                                    'height':'50px',
                                    'float':'right',
                                    'clear':'both'
                                });
                                $("#chat-messages").append(newMessage);
                                $("#chat-messages").scrollTop($("#chat-messages")[0].scrollHeight);
                                
                            }
                        }
                    }
                    // Update the last timestamp
                    if (data.length > 0) {
                        lastTimestamp = Date.parse(data[data.length - 1].timestamp);
                    }
                },
                error: function() {
                    console.log(lastTimestamp);
                }
            });
        }, 1000); // Refresh every 1 second
        
        // Send a chat message
        $("#send-message-form").submit(function(e) {
            e.preventDefault();
            console.log("hello");
            // // Get the message text
            var messageText = $("#message-text").val().trim();
        
            // // Only send the message if it's not empty
            if (messageText !== "") {
                // Call the send_message function to add the message to the database
                $.ajax({
                    type: "POST",
                    url: "chat_functions.php",
                    data: { roomId: roomId, username: username, message: messageText },
                    success: function(response) {
                        // Clear the message input field
                        $("#message-text").val("");
                    }
                });
            }
        });

        $("#myButton").click(function(e) {
            e.preventDefault();
            console.log("hello");
            $.ajax({
                type: "POST",
                url: "delete_room.php",
                data: { roomId: roomId, username:username},
                success: function(response) {
                    window.location.replace("home.php");
                }
            });
            
        });
    });
    
    </script>
</head>
<body>
    <div id="header">
        <h2 id="roomname"></h2>
        <div id="room-id"></div>
        <div id="username"></div>
        

    </div>
    <div id="chat-container">
        <div id="chat-messages"></div>
        <form id="send-message-form">
            <input type="text" id="message-text" placeholder="Type your message...">
            <button type="submit" id="send-button" ><img src="uploads/sentt.png" alt="Submit" style="width: 40px; height: 40px;"></button>
        </form>
    </div>
    
    <div class="dltbtn" style="text-align:center; margin-top:20px;"><form method="post" ><button id="myButton" class="btn btn-primary" type="submit">Delete room</button></form></div>
	<?php
		$showButton = ($username==$admin); // set this to true or false based on your condition

		if (!$showButton) {
			// If the condition is false, hide the button using CSS
			echo '<style>.dltbtn{ display: none; }</style>';
		}
	?>
    <div class="viewusersdiv" style="text-align:center;"><button id="viewusersbtn" class="btn btn-primary">View users</button></div>
	
    <div id="usersdiv"></div>
    <script>
        var btn=document.getElementById("viewusersbtn");
        var div=document.getElementById("usersdiv");
        div.style.display='none';
        
        btn.addEventListener('click',function(){
            if(div.style.display=='none')div.style.display='block';
            else div.style.display='none';
        });
    </script>
</body>
</html>