<?php
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

function contains($str, array $arr)
{
    foreach($arr as $a) {
        if (stripos($str,$a) !== false) return true;
    }
    return false;
}

$imagename=$_FILES["myimage"]["name"];
$photo_name = $_POST['photo_name'];
$photo_caption = $_POST['photo_caption'];

$file_formats = array('.jpg','.png','.jpeg','.gif');

if(!contains($imagename,$file_formats)){
  header("Location: upload.html");
}
else{
  $imagetmp=addslashes (file_get_contents($_FILES['myimage']['tmp_name']));

  $insert_image="INSERT INTO photo(image,caption,name) VALUES('" . $imagetmp . "', '" . $photo_caption . "', '" . $photo_name . "');";

  $query_check_user_name = $connection->query($insert_image);
}

?>
