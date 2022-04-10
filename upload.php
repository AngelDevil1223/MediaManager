<?php

include 'config.php';

$imageData = '';
$flag = 0;
if (isset($_FILES['file']['name'][0])) {
    foreach ($_FILES['file']['name'] as $keys => $values) {
        $fileName = uniqid() . '_' . $_FILES['file']['name'][$keys];
        $fileurl = "http://localhost/uploads/".$fileName;
        if (move_uploaded_file($_FILES['file']['tmp_name'][$keys], 'uploads/' . $fileName)) {
        	$realname = $_FILES['file']['name'][$keys];
	        $filesize = $_FILES['file']['size'][$keys];
	        $filesize = round($filesize / 1024 , 2) . " KB";
	        $image_info = getimagesize($fileurl);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
			$dimension = $image_width. "-" . $image_height;
			$cur_time = date('d-m-y h:i:s');
			$visible = 0;
            $sql = "INSERT INTO uploads (filename, updatedname, fileurl, dimension , filesize , uploadtime , alttext, caption, description , title , visible)	VALUES ('".$realname."', '".$fileName."', '".$fileurl."', '".$dimension."' , '".$filesize."', '".$cur_time."' , '', '' , '' ,'' , '".$visible."')";
			if (mysqli_query($conn, $sql)) {
			  // $imageData .= '<div style="background-image:url(uploads/' . $fileName . '); opacity: 0.4; background-position: center;  background-repeat: no-repeat; background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 30px; height: 30px; top: 33px; left: 33px;" src="load.gif" /></div>';
				$imageData .= $fileName.",";
			}
			else 
			  $imageData .= '<div class="thumbnail">Failed</div>';
        }
    }
}
echo $imageData;
