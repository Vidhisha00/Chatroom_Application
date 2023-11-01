<?php
// Database connection details
include 'connect.php';

// Send a message to the database
function send_message($roomId, $username, $message) {
    global $conn;
    $message = mysqli_real_escape_string($conn, $message);
    $sql = "INSERT INTO `$roomId` (`sender_name`, `message`) VALUES ('$username', '$message');";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Failed to send chat message: " . mysqli_error($conn));
    }
}
send_message($_POST['roomId'],$_POST['username'],$_POST['message']);
?>
