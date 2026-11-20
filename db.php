
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bloodlink_db";

$conn = new mysqli(
    $servername,
    $username,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
