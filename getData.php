<?php

include 'config.php';

$url = $_POST['id'];
$sql = "SELECT * FROM uploads WHERE fileurl = '".$url."'";

$result = mysqli_query($conn , $sql);
if(mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	echo json_encode($row);
}
