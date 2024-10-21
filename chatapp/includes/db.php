<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "chatapp";

$con = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
} 