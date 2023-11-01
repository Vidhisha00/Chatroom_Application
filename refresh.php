<?php
// Database connection details
include 'connect.php';
// Fetch messages from the database
function fetch_messages($roomId, $lastTimestamp, $username) {
    global $conn;

    // Query the database for new chat messages
    $sql = "SELECT * FROM $roomId WHERE sent_at > $lastTimestamp";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Failed to fetch chat messages: " . mysqli_error($conn));
    }

    // Build an array of chat messages
    $messages = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $f=($row['sender_name']==$username);
        $sql="SELECT * FROM `profile pictures` WHERE `username` = '{$row['sender_name']}';";
        $ok = mysqli_query($conn, $sql);
        $row2=mysqli_fetch_assoc($ok);
        $messages[] = array(
            "timestamp" => $row["sent_at"],
            "sender_name" => $row["sender_name"],
            "message" => $row["message"],
            "path" => $row2["profilepic"],
            "f" => $f
        );
    }

    // Return the array of chat messages as JSON
    header("Content-type: application/json");
    echo json_encode($messages);
}
fetch_messages($_POST['id'],$_POST['lastTimeStamp'],$_POST['username']);


?>
