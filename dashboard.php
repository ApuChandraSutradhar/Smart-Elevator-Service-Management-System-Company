<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}
$admin_name = $_SESSION['admin_name'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elevator_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include('../includes/header.php');

?>
