<?php include 'connect.php';

$sql="SELECT t.table_name FROM information_schema.tables t JOIN information_schema.columns c1 ON t.table_name = c1.table_name AND c1.column_name = 'id' JOIN information_schema.columns c2 ON t.table_name = c2.table_name AND c2.column_name = 'sender_name' JOIN information_schema.columns c3 ON t.table_name = c3.table_name AND c3.column_name = 'message' JOIN information_schema.columns c4 ON t.table_name = c4.table_name AND c4.column_name = 'sent_at' WHERE t.table_schema = 'chatroom';";

$result=mysqli_query($conn,$sql);
$tables=array();
if (mysqli_num_rows($result) > 0) {
    // Loop through result set and print table names
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($tables,$row['table_name']);
    }
} 
foreach($tables as $table){
    $result = mysqli_query($conn, "SHOW TABLE STATUS LIKE '$table'");
    $row = mysqli_fetch_assoc($result);
    $tableModifiedTime = $row['Update_time'];

    // Calculate the difference between the current time and the table's modification time
    $currentTime = time();
    $tableModifiedTimestamp = strtotime($tableModifiedTime);
    $timeDifference = $currentTime - $tableModifiedTimestamp;
    $sql="SELECT * FROM `rooms` WHERE `roomcode` = '$table';";
    echo $sql;
    $result=mysqli_query($conn,$sql);
    // Check if the table has not been modified for 24 hours
    if ($timeDifference > (24 * 60 * 60) || mysqli_num_rows($result)==0) {
        // If the table has not been modified for 24 hours, delete it
        mysqli_query($conn, "DROP TABLE IF EXISTS $table");
        mysqli_query($conn, "DELETE FROM `rooms` WHERE `roomcode` = '$table'");
        mysqli_query($conn,"DELETE FROM `user_room` WHERE `room` = '$table'");
        
    } 
   
}
?>
