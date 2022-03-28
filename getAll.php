<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medialibrary";
$echodata = [];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$i = 0;
$result = mysqli_query($conn,"SELECT * FROM uploads ");
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $echodata[$i] = $row;
    $i++;
  }
} else {
  echo "0 results";
}

echo json_encode($echodata);
