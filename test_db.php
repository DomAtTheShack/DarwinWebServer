<?php
$conn = new mysqli("db", "dominichann", "hidom@123", "mydatabase");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
echo "Connected successfully to MySQL!";
?>
