<?php include 'connect.php';
session_start();
$username="";
$f=0;
if(isset($_SESSION['username'])){
  $username=$_SESSION['username'];
  if(isset($_SESSION['s_cnt'])){
    $f=$_SESSION['s_cnt']+2;
    unset($_SESSION['s_cnt']);
  }
  else if(isset($_SESSION['signing_up'])){
    $f=1;
    unset($_SESSION['signing_up']);
  }
  if(isset($_SESSION['logged_in'])){
    $f=2;
    unset($_SESSION['logged_in']);
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Chatroom Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
    body{
        background-image: url('chatroom.jpg');
        background-size: 100% 100%;
  background-repeat: no-repeat;
  background-attachment: fixed;
    }
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.alert {
  z-index: 3000;
}

 /* CSS for the navbar */
 .navbar {
			overflow: hidden;
			background-color: #000;
			position: relative;
			top: 0;
			width: 100%;
}

/* CSS for the links within the navbar */
.navbar {
  display: flex;
  align-items: center;
}

.navbar a, .navbar h2 {
  float: left;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.navbar h2{
  margin: 0 auto;
}

.logout, .edit-profile-link {
  float: right;
  display: block;
  color: white;
  padding: 14px 16px;
  text-decoration: none;
}

main {
  margin:0 auto;
}
.content {
  max-width: 1000px;
  /* max-height:500px; */
  margin: 60px auto;
  text-align: center;
  padding: 50px;
  background-color: rgba(255,255,255,0.8);
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.2);
}

p {
  font-size: 1.5em;
  line-height: 1.5;
  max-width: 800px;
  margin: 0 auto;
  color:black;
}
.container{
    display:flex;
    justify-content:space-between;
    margin:0px auto;
    border-radius: 10px;
}

.btn-primary{
  color: white;
  background-color:#333;
  border:#333;
}
input{
  margin:20px;
}

.box {
  flex: 1;
  height: 300px;
}

.flex-container {
  display: flex;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.2);
}

.box:nth-child(1) {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.2);
  border:black;
  margin:5px;
}

.box:nth-child(2) {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.2);
  border:black;
  margin:5px;
}

#roomname,#roomcode{
    border-radius:5px;
}

.btn-primary[type="submit"]:hover {
      background-color:#495057;
 }


 /* Add this to your CSS file */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width:400px;
  text-align: center;
}

.modalbtn {
  margin: 5px;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.modalbtn:hover {
  background-color: #0069d9;
}

.modalbtn:active {
  background-color: #005cbf;
}

/* Close Button */
.close {
	color: #aaa;
	float: right;
	font-size: 28px;
	font-weight: bold;
	cursor: pointer;
}

.close:hover,
.close:focus {
	color: black;
	text-decoration: none;
	cursor: pointer;
}

.modalbtn{
  background-color:black;
}

.modalbtn:hover{
  background-color:#343a40;
}

#lates,#logout-link,#edit-profile-link{
      padding-top: 17px;
      padding-left: 48px;
      font-size:13pt;
}

#wc{
  padding-left: 140px;
  font-size:18pt;
}

   #formm{
      margin: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-family: Arial, sans-serif;
    }
    #labell{
      display: block;
      font-weight: bold;
      margin-left:15px;
      margin-top:5px;
      float:left;
      clear:left;
    }

    #usernamee,#passwordd {
      display: block;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      font-family: Arial, sans-serif;
      float:left;
      clear:left;
    }

  
    #editbtn{
      padding: 10px 20px;
      background-color: black;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      float:left;
    }
     #editbtn:hover{
    background-color: #333;
    }  
      ul {
      float:left;
      list-style-type: disc;
      margin-left: 20px;
      font-size: 16px;
      font-family: Arial, sans-serif;
      clear:left;
  
    } 
    li {
      float:left;
      margin-bottom: 10px;
      margin-left: -15px;
      clear:left;
    } 

    #rc{
      padding-top:9px;
    }
  

   
    /* #para{
      float:left;
      text-align:left;
      align-items:left;
    } */

  </style>
  
  </head>
  <?php 
    if($f==1){
   
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Welcome '.$username.'!</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==2){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Welcome back '.$username.'!</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==3){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Room does not exist.</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==4){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Login in to access the chatroom.</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==5){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Facing heavy loads!!</strong>We are working on fixing the issue.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==6){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sorry for inconvenience.</strong>We are working on fixing the issue.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==7){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Username already exists!!</strong>Can not edit your profile.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==8){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Password does not meet the requirements!!</strong>Can not edit your profile.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==22){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Profile updated!</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    else if($f==42){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Passowrd does not meet the requirements!!</strong>Can not edit your profile.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    $f=0;
  ?>
  <body>
  <div class="navbar">
		<a id="lates" href="home.php">Home</a>
		<?php if (!isset($_SESSION['username'])): ?>
			<a id="lates" href="index.php">Signup</a>
		<?php endif; ?>
		<h2 id="wc" >Welcome to chatroom</h2>
		<?php if (isset($_SESSION['username'])): ?>{<a href="#" id="edit-profile-link"  class="edit-profile-link" onclick="openEditProfileModal()">Edit Profile</a>
			<a class="logout" href="#" id="logout-link">Logout</a>}
		<?php endif; ?>
	</div>
  <!-- Edit Profile Link -->


<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
		<div class="modal-content">
			<span class="close" onclick="closeEditProfileModal()">&times;</span>
			<h2 id="edit profile">Edit Profile</h2>
			<form id="formm" action="edit.php" method="post" enctype="multipart/form-data">
				<label id="labell" for="username">Username:</label>
				<input idtype="text" id="usernamee" name="username" required>
				<label id="labell" for="password">Password:</label>
        <p id="para"><ul>
          <li>8-20 letters</li>
          <li>one special character</li>
          <li>one numeric letter</li>
        </ul></p>
				<input type="password" id="passwordd" name="password"><br>
				<label id="labell" for="image"> Profile picture:</label><input type="file" id="image" name="image">
				<input type="submit" value="Edit Profile" id="editbtn">
			</form>
		</div>
	</div>
  <script>
  // Get the modal
var editProfileModal = document.getElementById("editProfileModal");

// Get the link that opens the modal
var editProfileLink = document.getElementById("edit-profile-link");
console.log(editProfileModal);
    console.log(editProfileLink);
// When the user clicks on the link, open the modal
function openEditProfileModal() {
	editProfileModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
function closeEditProfileModal() {
	editProfileModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == editProfileModal) {
		editProfileModal.style.display = "none";
    
	}
}
</script>


  

<!-- Add this to the HTML body where you want the modal confirmation -->
<div id="logout-modal" class="modal">
  <div class="modal-content">
    <h6>Are you sure you want to logout?</h6>
    <button class="modalbtn" id="logout-confirm">Yes</button>
    <button class="modalbtn" id="logout-cancel">No</button>
  </div>
</div>
<script>
/* Add this to your JavaScript file */
// Get the logout link and the modal
const logoutLink = document.getElementById("logout-link");
const logoutModal = document.getElementById("logout-modal");

// When the logout link is clicked, show the modal
logoutLink.addEventListener("click", function() {
  logoutModal.style.display = "block";
});

// When the "Yes" button is clicked, redirect to the logout PHP file
document.getElementById("logout-confirm").addEventListener("click", function() {
  window.location.href = "logout.php";
});

// When the "No" button is clicked or the modal background is clicked, hide the modal
document.getElementById("logout-cancel").addEventListener("click", function() {
  logoutModal.style.display = "none";
});

window.addEventListener("click", function(event) {
  if (event.target == logoutModal) {
    logoutModal.style.display = "none";
  }
});

</script>
        <div class="content">
      <p>Connect with your friends and spend some quality time here:</p> 
      <div class="flex-container">
      <div class="container">
      <div class="box">
      
          
        <form action='createroom.php' method="post">
        <br>
        <img src="uploads/chatro.png" alt="Chatroom" width="190" height="120">
        Enter room name<br><input type="text" name="roomname" id="roomname" value=""><br>       
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <button class="btn btn-primary" type="submit"  name="createroombtn">Create Room</button>
            </form>
     
        </div>
        <div class="box">
        <form action='joinroom.php'method="post">
        <br>
        <img src="uploads/h2.jpg" alt="quote1" width="250" height="120"><br>
        
           Enter room code<br> <input type="text" name="roomcode" id="roomcode" value=""><br>
  
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            
            <button class="btn btn-primary" type="submit" name="joinroombtn">Join Room</button>
            </form>
 
        </div>
      </div>
</div>

</div>

  </body>
</html>