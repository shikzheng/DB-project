<?php
session_start();
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
    $file_formats = array('.jpg','.png','.jpeg','.gif');

    if(!contains($imagename,$file_formats)){
      header("Location: upload.php");
    }
    else{
      $stmt = $connection->prepare("INSERT INTO photo(image,caption,name,image_name) VALUES(?, ?, ?, ?)");
      $stmt->bind_param("ssss", $imgData, $photo_caption, $photo_name, $imagename);
      if($stmt->execute){
        $_SESSION['errorrrr'] = "Success";
      }else{
        echo("Error description: " . mysqli_error($connection));
        $_SESSION['errorrrr'] = "Fail";
      }
    }
  }
}
?>
<html>
<head>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<form name="frmImage" enctype="multipart/form-data" action="" method="post">
<label>Upload Image File:</label><br/>
  <label class="sr-only" for="photo_name">Photo Name</label>
  <input class="form-control" style = "height:45px;" placeholder="Photo Name" id="photo_name" class="login_input" type="text" name="photo_name"  required autofocus autocomplete="off" />
  <br>
  <label class="sr-only" for="photo_name">Caption</label>
  <input class="form-control" style = "height:45px;" placeholder="Photo Caption" id="photo_caption" class="login_input" type="text" name="photo_caption"  required autofocus autocomplete="off" />
  <br>
  <input name="userImage" type="file" class="inputFile" required/>
<input type="submit" value="Submit" class="btnSubmit" />
</form>
</div>
<?php
  if (isset($_SESSION['errorrrr'])) {
    $photo_name = $_POST['photo_name'];
    $select_image="select * from photo where name='" . $photo_name . "';";
    $var = $connection->query($select_image);
    if($row=$var->fetch_assoc()){
      echo '<div>' . $row['name'] . '</div>';
      echo '<img src = "data:image/jpg;base64,' . base64_encode($row['image']) . '">';
      echo '<div>' . $row['caption'] . '</div>';
    }
  }
?>
<div>
  <?php
    if(isset($_SESSION['errorrrr'])){
      echo $_SESSION['errorrrr'];
      unset($_SESSION['errorrrr']);
    }
  ?>
</div>
</body>
</html>
