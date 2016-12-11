<?php
session_start();
if(!isset($_SESSION['user_login_status'])){
  header("Location: index.php");
}
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  function contains($str, array $arr){
      foreach($arr as $a) {
          if (stripos($str,$a) !== false) return true;
      }
      return false;
  }

  if(count($_FILES) > 0) {
    if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        $imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));

        $imagename=$_FILES["userImage"]["name"];
        $photo_name = $_POST['photo_name'];
        $photo_caption = $_POST['photo_caption'];
        $eventid = $_POST['eventid'];
        $username = $_POST['username'];

        $file_formats = array('.jpg','.png','.jpeg','.gif');

        if(!contains($imagename,$file_formats)){
          $_SESSION['uploadErrorMsg'] = "Error: Not an Image.";
        }
        else{
          $sql = "INSERT INTO photo(image,caption,name,image_name,username)
          VALUES('" . $imgData . "', '" . $photo_caption . "', '" . $photo_name . "', '" . $imagename . "', '" . $username . "')";
          $result = $connection->query($sql);
          $id = $connection->insert_id;
          $sql2 = "INSERT INTO photo_of(p_id,event_id)
          VALUES('" . $id . "', '" . $eventid . "')";
          $result2 = $connection->query($sql2);
          if($result && $result2){
            $_SESSION['errorrrr'] = "Success";
          }else{
            echo("Error description: " . mysqli_error($connection));
            $_SESSION['errorrrr'] = "Fail";
          }
        }
      }
    }
    header("Location: eventPage.php");
?>
