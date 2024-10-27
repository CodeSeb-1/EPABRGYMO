<?php

session_start();
include_once("db.php");

$outgoing_id = $_SESSION['unique_id'];
$sql = mysqli_query($con,"SELECT * FROM users");
$output = "";
if(mysqli_num_rows($sql) === 1) {
    $output .= "No users are availabke to chat";// eto parang hindi ko naamn need kasi need pa din i chat e

} else if (mysqli_num_rows($sql) > 0) {
    include("data.php");
}
echo $output;
