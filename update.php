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
$imgTag = $_POST['imgTag'];

$sql = "SELECT * FROM categories WHERE cate_name = '".$imgTag."'";
$result = mysqli_query($conn , $sql);
if(mysqli_num_rows($result) > 0) {
	
}
else {
	$sql1 = "INSERT INTO categories (cate_name) VALUES ('".$imgTag."')";
	$result1 = mysqli_query($conn, $sql1);
}


$sql = "UPDATE uploads SET alttext='".$altText."' , caption='".$imgCaption."' , description='".$imgDes."', title='".$imgTitle."' , cate_name = '".$imgTag."' WHERE fileurl = '".$url."'";
$result = mysqli_query($conn , $sql);

echo "success";

?>