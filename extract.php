<?php

include 'config.php';

if($_FILES['zip_file']['name'] != ''){
	$output = "";
	$file_name = $_FILES['zip_file']['name'];
	$array = explode(".", $file_name);
	$name = $array[0];
	$ext = $array[1];
	if($ext == 'zip'){
		$path = 'upload/';
		$location = $path . $file_name;

		$tempdir = $path . uniqid();
		mkdir($tempdir);
		if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)){
			$zip = new ZipArchive;
			if($zip->open($location)){
				$zip->extractTo($tempdir);
				$zip->close();
			}
			$files = scandir($tempdir);
			$i = 0;
			$echodata = [];
			foreach($files as $file){
				$tmp_ext = explode(".", $file);
				$file_ext = end($tmp_ext);
				$allowed_ext = array('jpg', 'png', 'jpeg', 'gif');
				if(in_array($file_ext, $allowed_ext)){
					$new_file = $tmp_ext[0].".".$file_ext;
						$echodata[$i] = 'http://localhost/' . $tempdir . '/' . $new_file;

						$filename = $new_file;
						$updatedname = $filename;
						$fileurl = $echodata[$i];
						$cur_time = date('d-m-y h:i:s');

						$filesize = filesize($tempdir . '/' . $new_file);
					$filesize = round($filesize / 1024 , 2) . " KB";
					$image_info = getimagesize($tempdir . '/' . $new_file);
					$image_width = $image_info[0];
					$image_height = $image_info[1];
					$dimension = $image_width. "-" . $image_height;
					$visible = 0;
					$sql = "INSERT INTO uploads (filename, updatedname, fileurl, dimension , filesize , uploadtime , alttext , caption , description , title , visible) VALUES ('".$filename."', '".$updatedname."', '".$fileurl."', '".$dimension."' , '".$filesize."', '".$cur_time."', '' , '' , '' , '' , '".$visible."')";
						$result = mysqli_query($conn , $sql);
						$i ++ ;
					// $output .= "<br />".$new_file."<center><img src='upload/".$name."/".$new_file."' height='50px' width='50px'/></center>";

				}
			}
			unlink($path.$name.'.'.$ext);
		}
	}

	echo json_encode($echodata);
}
 
?>