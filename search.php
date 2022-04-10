<?php

include 'config.php';

$url = $_POST['indexWord'];
$sql = "SELECT * FROM uploads WHERE title LIKE '%".$url."%'";

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

echo json_encode($echodata);

