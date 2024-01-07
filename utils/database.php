<?php

$hostName = "";
$dbUser = "";
$dbPassword = "";
$dbName = "";

// $hostName = "localhost";
// $dbUser = "root";
// $dbPassword = "";
// $dbName = "mds";


$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
