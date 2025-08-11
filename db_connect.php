<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent_a_car";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>
