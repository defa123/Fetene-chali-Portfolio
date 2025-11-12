<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = ""; // your MySQL password
$db   = "portfolio";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
