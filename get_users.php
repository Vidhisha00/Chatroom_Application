<?php 
session_start();
include 'connect.php'; 
$roomId=$_SESSION['roomcode'];
$sql = "SELECT * FROM `user_room` WHERE `room` = '$roomId'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Failed to fetch chat messages: " . mysqli_error($conn));
}

// Build an array of chat messages
$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sql="SELECT * FROM `profile pictures` WHERE `username` = '{$row['user']}';";
    $ok = mysqli_query($conn, $sql);
    $row2=mysqli_fetch_assoc($ok);
    $f=$row['status'];
    $users[] = array(
        "timestamp" => $row["timestamp"],
        "username" => $row["user"],
        "path" => $row2["profilepic"],
        "blocked"=>$f
    );
}
header("Content-type: application/json");
echo json_encode($users);


?>