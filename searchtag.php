<?php

include 'config.php';

$tag = $_POST['tag'];
$sql = "SELECT * FROM uploads WHERE cate_name LIKE '%".$tag."%' AND visible = 0";

$echodata = [];
$i = 0;
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $echodata[$i] = $row;
    $i++;
  }
} else {
  echo "0 results";
}

$sql1 = " UPDATE `uploads` SET visible = 1 WHERE cate_name LIKE '%".$tag."%'" ;
$result1 = mysqli_query($conn , $sql1);

echo json_encode($echodata);

