<?php

include 'config.php';

$pageSize = $_POST['page'];
$i = 0;
$result = mysqli_query($conn,"SELECT * FROM uploads ORDER BY id DESC LIMIT ".$pageSize);
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
