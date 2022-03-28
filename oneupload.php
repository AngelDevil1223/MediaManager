<?php
//upload.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medialibrary";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST["image_url"]))
{
 $message = '';
 $image = '';
 if(filter_var($_POST["image_url"], FILTER_VALIDATE_URL))
 {
  $url_array = explode("/", $_POST["image_url"]);
  $image_name = end($url_array);
  $image_array = explode(".", $image_name);
  $extension = end($image_array);
  $image_data = file_get_contents($_POST["image_url"]);
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

  $image_width = $image_info[0];
  $image_height = $image_info[1];
  $dimension = $image_width. "-" . $image_height;
  $cur_time = date('d-m-y h:i:s');
  $sql = "INSERT INTO uploads (filename, updatedname, fileurl, dimension , filesize , uploadtime , alttext , caption , description , title ) VALUES ('".$realname."', '".$uploadedname."', '".$fileurl."', '".$dimension."' , '".$filesize."', '".$cur_time."' , '' , '', '', '' )";
  $result = mysqli_query($conn , $sql);
  $output = array(
  'message' => "sucess",
  'image'  => $fileurl,
 );
 echo json_encode($output);
 }
}

?>