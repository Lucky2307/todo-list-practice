<?php
// DB Setup
$servername = '127.0.0.1';
$username = getenv("MySqlUser");
$password = getenv("MySqlPassword");
$dbname = 'todo';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
