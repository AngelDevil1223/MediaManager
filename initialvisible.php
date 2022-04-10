<?php

include 'config.php';

$sql = "UPDATE uploads SET visible = 0 ";
$result = mysqli_query($conn , $sql);

echo "success";

?>