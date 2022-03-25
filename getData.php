<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medialibrary";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$url = $_POST['id'];
$sql = "SELECT * FROM uploads WHERE fileurl = '".$url."'";

$result = mysqli_query($conn , $sql);
if(mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	echo json_encode($row);
}
