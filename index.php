<?php include 'connect.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function send_mail($email,$username,$code){
  require('phpmailer/PHPMailer.php');
  require('phpmailer/SMTP.php');
  require('phpmailer/Exception.php');
  $mail = new PHPMailer(true);
  try {    
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output                 
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'jinayshah0303@gmail.com';                     //SMTP username
    $mail->Password   = 'ksvmvuvzwyvamihc';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('jinayshah0303@gmail.com', 'chatroom');
    $mail->addAddress($email, $username);     //Add a recipient
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email verification';
    $mail->Body    = "Thanks for the registration. Verify your email address by clicking on this link <a href='http://localhost/chatr/verify.php?email=$email&code=$code'>Verify</a>";

    $mail->send();return true;
} catch (Exception $e) {
  return false;
}
}
  // Set default values for the form fields
  $username1 = '';
  $password1 = '';
  $cpassword1 = '';
  $username2 = '';
  $password2 = '';
  $email='';
  $cnt=0;
  // Check if the form was submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Determine which form was submitted
    
    if (isset($_POST['signup'])) {
      // Set the form fields to the submitted values
      $username1 = $_POST['username1'];
      $password1 = $_POST['password1'];
      $cpassword1 = $_POST['cpassword1'];
      $email = $_POST['email1'];
      if($cpassword1==$password1){
        $sql="SELECT * FROM `accounts` WHERE `username` = '$username1'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          $cnt=1;
        }
        else{

          if (preg_match('/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%^&*(),.?":{}|<>]{8,20}$/', 
          $password1)) {
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
              $sql="SELECT * FROM `accounts` WHERE `email` = '$email'";
              $result=mysqli_query($conn,$sql);
              if(mysqli_num_rows($result)==0){
                $code=bin2hex(random_bytes(16));
                $sql="INSERT INTO `accounts` (`username`, `password`,`email`,`code`,`status`) VALUES ('$username1', '$password1','$email','$code','0');";
                $result=mysqli_query($conn,$sql);
                $f=send_mail($email,$username1,$code);
                if($result && $f){
                      $fileName = $_FILES['image']['name'];
                      $fileTmpName=$_FILES['image']['tmp_name'];
                      $fileError=$_FILES['image']['error'];       
                      if ($fileError==0) {
                          $uploadDir = 'uploads/';
                          $fileNewName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                          $uploadPath = $uploadDir . $fileNewName;
                          if (move_uploaded_file($fileTmpName, $uploadPath)) {
                      
                          } else {
                              $uploadPath="uploads/"."default.jpeg";
                          }
                      } else {
                          $uploadPath="uploads/"."default.jpeg";
                      }
                      $sql="INSERT INTO `profile pictures` (`username`, `profilepic`) VALUES ('$username1', '$uploadPath');";
                      $result=mysqli_query($conn,$sql);
                      
                      header("Location:verifyemail.php");
                      exit();
                    }
                    else{
                      
                      $cnt=2;
                      //'Sorry for inconvenience. Fault on our side.'
                    }
                  }
                  else{
                      $cnt=7;
                        //email already registered
                  }
                
            }
            else{
              $cnt=8;
              //email does not exists
            }
        }
        else{
          $cnt=4;
          //password doesn't meet requirements.
        }
      }
    }
    else{
      $cnt=3;
        //'Confirm password does not match with original password.'
        
    }
    } elseif (isset($_POST['login'])) {
      // Set the form fields to the submitted values
      $username2 = $_POST['username2'];
      $password2 = $_POST['password2'];
     
        
        $sql="SELECT * FROM `accounts` WHERE `username` = '$username2'";
        $result=mysqli_query($conn,$sql);
        $sql="SELECT * FROM `accounts` WHERE `email`='$username2'";
        $result1=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==0 && mysqli_num_rows($result1)==0){

            //username or email doesnt exist
            $cnt=5;
          
        }
        else{
            if(mysqli_num_rows($result)){
              while ($row = mysqli_fetch_assoc($result)) {
                
                  if ($password2==$row['password']) {
                      if($row['status']=='0'){
                          $cnt=10;
                      }
                      else{$_SESSION['username']=$username2;
                      $_SESSION['logged_in']='yes';
                      header("Location:home.php");}
                  } else {
                    $cnt=6;
                  }
              }
            }
            else{
              while ($row = mysqli_fetch_assoc($result1)) {
                
                if ($password2==$row['password']) {
                  if($row['status']=='0'){
                      $cnt=10;
                  }
                  else{$_SESSION['username']=$username2;
                  $_SESSION['logged_in']='yes';
                  header("Location:home.php");}
              } else {
                $cnt=6;
              }
            }
            }
           
        }
    }
  }
  
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup Page</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* background-image: url('uploads/signup.png'); */
    /* background-size: cover;
   */
    }

    .buttons{
      width:40%;
      margin:0 auto;
      padding: 10px 20px;
      font-size: 16px;
      /* background-color: #00b894; */
      color: #fff;
      border-color: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color .3s ease-in-out;
      padding-bottom:40px;
      padding-top:25px;
    }

    
    .signupform{
      width: 40%; /* set the width of the container */

      margin: 0 auto; 
      padding: 40px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,.1);
      border-radius: 8px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      font-size:10px;
    }

    .loginform{
      display:none;
      width: 40%; 
      
      margin: 0 auto; 
      padding: 40px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,.1);
      border-radius: 8px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      font-size:10px;
    } 
    .form-container{
      margin:0 auto;
      text-align:left;
    }

    form label {
      display: block;
      margin-bottom: 10px;
      font-size: 16px;
      color: #333;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="password"] 
    {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 20px;
      align:center;
    }
    form input[type="file"]{
      width: 80%;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 20px;
      align:center;
    }

    form button[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: black;
      color: #fff;
      border: none;
      border-radius: 7px;
      cursor: pointer;
      transition: background-color .3s ease-in-out;
      text-align:left;
    }


    form button[type="submit"]:hover {
      background-color: #343a40;
    }

    #username1,#password1,#cpassword1,#username2,#password2,#email1{
      border-radius: 10px;
      border-width: 2px;
      border-style: inset;
      border-color: -internal-light-dark(rgb(118, 118, 118), rgb(133, 133, 133));
      border-image: initial;
    }
    #button-1,#button-2{
      background-color:black;
      color:white;
      border-radius: 7px;
      border-color:black;
      padding: 10px;
    }

    #button-1:active {
      background-color: #343a40;
    }
    #button-1:hover {
      background-color: #343a40;
      border-radius: 7px;
      border-color:#343a40;
      padding: 10px;
    }

    #button-2:active {
      background-color: #343a40;
    }
    #button-2:hover {
      background-color: #343a40;
      border-radius: 7px;
      border-color:#343a40;
      padding: 10px;
    }

    #acc{
      text-align:center;
      align:center;
    }

    #imk{
      padding: 15px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      display: inline-block;
    }

    nav {
	    background-color: black;
	    overflow: hidden;
    }

    nav a {
	    float: left;
	    color: white;
	    text-align: center;
	    padding: 14px 16px;
	    text-decoration: none;
	    font-size: 17px;
    }

    nav a:hover {
	    /* transform:scale(1.5);  */
	    color: white;
    }

    .navbar {
      overflow: hidden;
      display: flex;
      justify-content: center;
    }

    #nn{
      padding:20px;
      align:center;
      padding-left:406px;
      color:white;
    }

    #anc{
      padding-top: 19px;
      font-size: 30px;
      padding-left: 48px;
      font-size:21pt;
    }

    #anc1{
      padding-top: 15px;
      padding-left: 167px;
      font-size: 20px;
    }
    
    .form-group{
      text-align:left;
    }

    .SignUpp{
       padding-left:0px;
     }

  </style>


</head>
<body>


<?php 
if($cnt==1){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Username already exists.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==2){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Sorry for inconvenience. We are fixing the issue.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==3){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Confirm password field should match with original password field.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==4){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Password doesn\'t meet the requirements.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==5){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Username or email doesn\'t exists. Please sign up to register.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==6){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Incorrect password.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==7){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Email already registered.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==8){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Email does not exists.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if($cnt==10){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Verification email pending. Check your mail box.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
$cnt=0;
?>
<div id="error"></div>
<nav>
		<a id="anc" class="active" href="home.php">Home</a>
    <h2 id="nn">Welcome to the Chatroom &nbsp;</h2>
</nav>


<iframe id="hidden-iframe" style="display:none;"></iframe>
  <div class="forms">
    <br>
    <div class="form-container">
      <form id="form-1" class="signupform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" autocomplete="off">
        <h2>Create an account</h2>
        <div class="form-group">
        <label for="username1">Username:</label>
        <input type="text" id="username1" name="username1" required>
        </div>
        
        <div class="form-group">
        <label for="email1">Email:</label>
        <input type="email" id="email1" name="email1" required>
        </div>
        

        <div class="form-group">
        <label for="password1">Password(should contain 8-20 letters, one special character, one numeric letter):</label>
        <input type="password" id="password1" name="password1" required>
        </div>

        <div class="form-group">
        <label for="cpassword1">Confirm Password:</label>
        <input type="password" id="cpassword1" name="cpassword1" required>
        </div>
        <div class="form-group">
        <label for="image">Upload an image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="ss">
        <button type="submit" class="SignUpp" name="signup">Sign up</button></div>

      
      </form>

      <form id="form-2" class="loginform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="off">
        <h2>Login</h2>
        <div class="form-group">
          <label for="username2">Username or Email:</label>
          <input type="text" id="username2" name="username2" required>
        </div>
        
        <div class="form-group">
          <label for="password2">Password:</label>
          <input type="password" id="password2" name="password2" required>
        </div>
        
        
        <button type="submit" name="login">Login</button>
      
      </form>

      <div class="buttons">
          <button id="button-1" onClick="startsignup()">Sign up to create an account</button>
           <button id="button-2" onClick="startlogin()">Login on existing account</button>
      </div>

      
    </div>
  </div>
  
<script>
  
  function startsignup(){
		var form = document.querySelector('.signupform');
		form.style.display = 'block';
        document.getElementById("hidden-iframe").display = "block";
        var form = document.querySelector('.loginform');
		form.style.display = 'none';

  }
  function startlogin(){
    var form = document.querySelector('.signupform');
		form.style.display = 'none';
        var form = document.querySelector('.loginform');
		form.style.display = 'block';
        document.getElementById("hidden-iframe").display = "block";
       
  }
  
</script>

</body>
</html>