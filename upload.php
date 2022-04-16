<?php

include 'config.php';

	// Drag and drop file upload parts
	if (isset($_FILES['file']['name'][0])) {
		$imageData = '';
		$flag = 0;
	    foreach ($_FILES['file']['name'] as $keys => $values) {
	        $fileName = uniqid() . '_' . $_FILES['file']['name'][$keys];
	        $fileurl = "http://localhost/uploads/".$fileName;
	        if (move_uploaded_file($_FILES['file']['tmp_name'][$keys], 'uploads/' . $fileName)) {
	        	$realname = $_FILES['file']['name'][$keys];
		        $filesize = $_FILES['file']['size'][$keys];
		        $filesize = round($filesize / 1024 , 2) . " KB";
		        $image_info = getimagesize($fileurl);
		        if($image_info != null) {
					$image_width = $image_info[0];
					$image_height = $image_info[1];
					$dimension = $image_width. "-" . $image_height;
				}
				else {
					$dimension = "none";
				}
				$cur_time = date('d-m-y h:i:s');
				$visible = 0;
	            $sql = "INSERT INTO uploads (filename, updatedname, fileurl, dimension , filesize , uploadtime , alttext, caption, description , title , visible)	VALUES ('".$realname."', '".$fileName."', '".$fileurl."', '".$dimension."' , '".$filesize."', '".$cur_time."' , '', '' , '' ,'' , '".$visible."')";
				if (mysqli_query($conn, $sql)) {
					$imageData .= $fileName.",";
				}
				else { 
				  	$imageData .= '<div class="thumbnail">Failed</div>';
	        	}
	        }
	    }
		echo $imageData;
		return ;
	}

	// zip file extract and upload part.
	if(isset($_FILES['zip_file']['name'])) {
		$output = "";
		$file_name = $_FILES['zip_file']['name'];
		$array = explode(".", $file_name);
		$name = $array[0];
		$ext = $array[1];
		if($ext == 'zip'){
			$path = 'uploads/';
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

					}
				}
				unlink($path.$name.'.'.$ext);
			}
		}

		echo json_encode($echodata);
		return ;
	}

	// One file upload from url
	if(isset($_POST["image_url"])) {
	    $message = '';
	    $image = '';
	    if(filter_var($_POST["image_url"], FILTER_VALIDATE_URL))
	    {
		    $url_array = explode("/", $_POST["image_url"]);
		    $image_name = end($url_array);
		    $image_array = explode(".", $image_name);
		    $extension = end($image_array);
		    $image_data = file_get_contents($_POST["image_url"]);
		    if($image_data == null) {
		    	
		    	return;
		    }
		    $uploadedname = rand(). "." .$extension; 
		    $new_image_path = "uploads/" . $uploadedname;
		    file_put_contents($new_image_path, $image_data);
		    $fileurl = "http://localhost/uploads/".$uploadedname; // data to insert.
		    $realname = $image_name;  // data to insert
		    // $filesize = $image_data;
		    // 
		    $image_info = getimagesize($fileurl);
		    $filesize = filesize($new_image_path);
		    $filesize = round($filesize / 1024 , 2) . " KB";

		    if ($image_info != null) {
		      $image_width = $image_info[0];
		      $image_height = $image_info[1];
		    }
		    else {
		      $image_width = ' ';
		      $image_height = ' ';
		    }

		    $dimension = $image_width. "-" . $image_height;
		    $cur_time = date('d-m-y h:i:s');
		    $visible = 0;
		    $sql = "INSERT INTO uploads (filename, updatedname, fileurl, dimension , filesize , uploadtime , alttext , caption , description , title , visible) VALUES ('".$realname."', '".$uploadedname."', '".$fileurl."', '".$dimension."' , '".$filesize."', '".$cur_time."' , '' , '', '', '' , '".$visible."')";
		    $result = mysqli_query($conn , $sql);
		    $output = array(
		    'message' => "sucess",
		    'image'  => $fileurl,
		    );
		    echo json_encode($output);
		    return ;
		}
	}

	// Get Detail data when click image in gallery of Gallery tab
	if(isset($_POST['getdata'])) {
		$url = $_POST['id'];
		$sql = "SELECT * FROM uploads WHERE fileurl = '".$url."'";

		$result = mysqli_query($conn , $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			echo json_encode($row);
		}
	}

	// When click save of details of each image in gallery
	if(isset($_POST['eachimg'])) {
		$url = $_POST['url'];
		$altText = $_POST['altText'];
		$imgTitle = $_POST['imgTitle'];
		$imgCaption = $_POST['imgCaption'];
		$imgDes = $_POST['imgDes'];
		$imgTag = $_POST['imgTag'];
		if($imgTag != '') {
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
		}
		$sql = "UPDATE uploads SET alttext='".$altText."' , caption='".$imgCaption."' , description='".$imgDes."', title='".$imgTitle."' , cate_name = '".$imgTag."' WHERE fileurl = '".$url."'";
		$result = mysqli_query($conn , $sql);

		echo "success";
	}

	// when click checkbox of tag for searching tag
	if(isset($_POST['truetag'])) {
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
	}

	// when insert indexword in search input tag
	if(isset($_POST['indexWord'])) {
		$url = $_POST['indexWord'];
		$sql = "SELECT * FROM uploads WHERE title LIKE '%".$url."%'";

		$echodata13 = [];
		$i = 0;
		$result = mysqli_query($conn,$sql);
		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
		    $echodata13[$i] = $row;
		    $i++;
		  }
		} else {
		  echo "0 results";
		}
		echo json_encode($echodata13);
	}

	// tick search tag 
	if(isset($_POST['searchtag'])) {
		$tag = $_POST['tag'];
		$sql = "SELECT * FROM uploads WHERE cate_name LIKE '%".$tag."%' AND visible = 0";

		$echodata12 = [];
		$i = 0;
		$result = mysqli_query($conn,$sql);
		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
		    $echodata12[$i] = $row;
		    $i++;
		  }
		} else {
		  echo "0 results";
		}

		$sql1 = " UPDATE `uploads` SET visible = 1 WHERE cate_name LIKE '%".$tag."%'" ;
		$result1 = mysqli_query($conn , $sql1);
		echo json_encode($echodata12);
	}

	// initial visible value when start
	if(isset($_POST['initial'])) {
		$sql = "UPDATE uploads SET visible = 0 ";
		$result = mysqli_query($conn , $sql);

		

	}

	// when click loadmore btn
	if(isset($_POST['page'])) {
		$pageSize = $_POST['page'];
		$i = 0;
		$result = mysqli_query($conn,"SELECT * FROM uploads ORDER BY id DESC LIMIT ".$pageSize);
		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
		    $echodata11[$i] = $row;
		    $i++;
		  }
		} else {
		  echo "0 results";
		}

		echo json_encode($echodata11);
	}

	// when untick all option tag , get All data
	if(isset($_POST['getall'])) {
		$i = 0;
		$result = mysqli_query($conn,"SELECT * FROM uploads ");
		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
		    $echodata10[$i] = $row;
		    $i++;
		  }
		} else {
		  echo "0 results";
		}

		echo json_encode($echodata10);
	}

	// when delete btn click
	if(isset($_POST['delete'])) {
		$url = $_POST['id'];
		$sql = "DELETE FROM `uploads` WHERE fileurl='".$url."'";
		if ($conn->query($sql) === TRUE) {
		  echo "Record deleted successfully";
		  return;
		}
	}

	// when change media type drop down list
	if(isset($_POST['mediaType'])) {
		$type = $_POST['mediaType'];
		$filter = '';
		switch ($type) {
			case 'All media items':
				$filter = 'SELECT * FROM `uploads` WHERE filename LIKE "%%"';
				break;
			
			case 'Image':
				$filter = 'SELECT * FROM `uploads` WHERE filename LIKE "%.jpg%" or filename LIKE "%.png%" or filename LIKE "%.jpeg%"';
				break;

			case 'Audio':
				$filter = 'SELECT * FROM `uploads` WHERE filename LIKE "%.mp3%" ';
				break;

			case 'Video':
				$filter = 'SELECT * FROM `uploads` WHERE filename LIKE "%.mp4%" or filename LIKE "%.avi%"';
				break;
		}

		$i = 0;
		$echodata10 = [];
		$result = mysqli_query($conn,$filter);
		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
		    $echodata10[$i] = $row;
		    $i++;
		  }
		} else {
		  echo "0 results";
		}
		echo json_encode($echodata10);
		return ;
	}

	// get all rows when start
	if(isset($_POST['getRow'])) {
		$sql = "SELECT count(id) as num FROM `uploads`";
		$result = mysqli_query($conn , $sql);
		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
		    echo $row['num'];
		  }
		} else {
		  echo "0 results";
		}
		return;
	}

	// when change startFrom date input
	if(isset($_POST['startFrom'])) {
		$start = strval($_POST['startFrom']);
		$i = 0;
		$echodata = [];
		$string = '';
		$sql = "SELECT * FROM uploads";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  while($row = $result->fetch_assoc()) {
		    $string = $row["uploadtime"];
		    $string = "20".substr($string, 6 ,2).substr($string, 3 ,2).substr($string, 0, 2);
		    $string = strval($string);
		    if($string >= $start) {
		    	$echodata[$i] = $row;
		    	$i ++;
		    }
		  }
		} else {
		  echo "0 results";
		}
		echo json_encode($echodata);
	}

	// when change startTo date input
	if(isset($_POST['startTo'])) {
		$end = strval($_POST['startTo']);
		$i = 0;
		$echodata = [];
		$string = '';
		$sql = "SELECT * FROM uploads";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  while($row = $result->fetch_assoc()) {
		    $string = $row["uploadtime"];
		    $string = "20".substr($string, 6 ,2).substr($string, 3 ,2).substr($string, 0, 2);
		    $string = strval($string);
		    if($string <= $end) {
		    	$echodata[$i] = $row;
		    	$i ++;
		    }
		  }
		} else {
		  echo "0 results";
		}
		echo json_encode($echodata);
	}

	// when change nextFrom and nextTo date input
	if(isset($_POST['nextFrom'])) {
		$start = strval($_POST['nextFrom']);
		$to = strval($_POST['nextTo']);
		$i = 0;
		$echodata = [];
		$string = '';
		$sql = "SELECT * FROM uploads";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  while($row = $result->fetch_assoc()) {
		    $string = $row["uploadtime"];
		    $string = "20".substr($string, 6 ,2).substr($string, 3 ,2).substr($string, 0, 2);
		    $string = strval($string);
		    if($string >= $start && $string <= $to) {
		    	$echodata[$i] = $row;
		    	$i ++;
		    }
		  }
		} else {
		  echo "0 results";
		}
		echo json_encode($echodata);
	}
?>