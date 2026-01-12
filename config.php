<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

 
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "ngo_db");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
