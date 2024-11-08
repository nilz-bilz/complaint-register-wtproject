<?php
$servername = "db"; //replace with ip:port or docker service name
$username = "root"; //enter DB user
$password = "root_pass"; // enter DB password
$dbname = "complaint_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
