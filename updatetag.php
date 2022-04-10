<?php

include 'config.php';

$tag = $_POST['tag'];
$echodata = [];

$sql1 = " UPDATE `uploads` SET visible = 0 WHERE cate_name LIKE '%".$tag."%' " ;
$result1 = mysqli_query($conn , $sql1);

$truetag = $_POST['truetag'];

$truetag = explode(",",$truetag);
$j = 0;

for($i = 0 ; $i < count($truetag) - 1 ; $i++) {
	$sql = "UPDATE `uploads` SET visible = 1 WHERE cate_name LIKE '%".$truetag[$i]."%'";
	$result = mysqli_query($conn , $sql);
}

$sql = "SELECT * FROM uploads WHERE visible = 1";
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
	while($row = mysqli_fetch_assoc($result)) {
	    $echodata[$j] = $row;
	    $j++;
	}
}


echo json_encode($echodata);
