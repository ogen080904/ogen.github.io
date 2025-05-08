<?php
$servername = "localhost";  // or your database server
$username = "root";         // your database username
$password = "";             // your database password (if none, leave empty)
$dbname = "anta_db";     // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>