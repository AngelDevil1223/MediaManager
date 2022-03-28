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

$url = $_POST['url'];
$altText = $_POST['altText'];
$imgTitle = $_POST['imgTitle'];
$imgCaption = $_POST['imgCaption'];
$imgDes = $_POST['imgDes'];

$sql = "UPDATE uploads SET alttext='".$altText."' , caption='".$imgCaption."' , description='".$imgDes."', title='".$imgTitle."' WHERE fileurl = '".$url."'";
$result = mysqli_query($conn , $sql);

echo "success";

?>