<?php

include 'config.php';

$url = $_POST['url'];
$altText = $_POST['altText'];
$imgTitle = $_POST['imgTitle'];
$imgCaption = $_POST['imgCaption'];
$imgDes = $_POST['imgDes'];
$imgTag = $_POST['imgTag'];
$string = $imgTag;
$string = str_replace(' ' , '', $string);
$string = explode(",",$string);

for($i = 0 ; $i < count($string) ; $i++) {

	$sql = "SELECT * FROM categories WHERE cate_name = '".$string[$i]."'";
	$result = mysqli_query($conn , $sql);
	if(mysqli_num_rows($result) > 0) {
		
	}
	else {
		$sql1 = "INSERT INTO categories (cate_name) VALUES ('".$string[$i]."')";
		$result1 = mysqli_query($conn, $sql1);
	}

}

$sql = "UPDATE uploads SET alttext='".$altText."' , caption='".$imgCaption."' , description='".$imgDes."', title='".$imgTitle."' , cate_name = '".$imgTag."' WHERE fileurl = '".$url."'";
$result = mysqli_query($conn , $sql);

echo "success";

?>