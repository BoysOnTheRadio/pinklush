<?php
session_start();
$host = 'localhost';
$db = 'pinklush_system';
$user = 'root';
$pass = "1234";     

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>