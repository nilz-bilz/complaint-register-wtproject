<!-- config.php -->
<?php
$servername = "127.0.0.1:3306";
$username = "root"; //enter DB user
$password = ""; // enter DB password
$dbname = "complaint_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
