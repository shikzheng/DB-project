<?php
session_start();
if (isset($_GET['event_page_eventid'])){
$_SESSION['event_page_eventid'] = $_GET['event_page_eventid'];
}
if(!isset($_SESSION['user_login_status'])){
  header("Location: index.php");
}else if (!isset($_GET['event_page_eventid']) && !isset($_SESSION['event_page_eventid'])){
  header("Location: group.php");
}

require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$eventid =  $_SESSION['event_page_eventid'];

$title = array();
$description = array();
$startTime = array();
$endTime = array();
$locationName = array();
$zipcode = array();
$groupid = array();
$gid = "";
$groupName = array();


$eventAddress = array();
$eventDescription = array();
$latitude = array();
$longitude = array();
if (!$connection->connect_errno) {
  $sql = "SELECT title,an_event.description,start_time,end_time,location_name,zipcode,group_id FROM organize NATURAL JOIN an_event WHERE event_id = '" . $eventid . "';";
  $query= $connection->query($sql);
  while($row = $query->fetch_assoc()){
    array_push($title, $row['title']);
    array_push($description, $row['description']);
    array_push($startTime, $row['start_time']);
    array_push($endTime, $row['end_time']);
    array_push($locationName, $row['location_name']);
    array_push($zipcode, $row['zipcode']);
    array_push($groupid, $row['group_id']);
  }
  $gid = $groupid[0];
  $sql2 = "SELECT group_name FROM a_group WHERE group_id = '" . $gid . "';";
  $query2= $connection->query($sql2);
  while($row = $query2->fetch_assoc()){
    array_push($groupName, $row['group_name']);
  }

  $sql3 = "SELECT address,description,latitude,longitude FROM location WHERE location_name = '" . $locationName[0] . "';";
  $query3= $connection->query($sql3 );
  while($row = $query3->fetch_assoc()){
    array_push($eventAddress, $row['address']);
    array_push($eventDescription, $row['description']);
    array_push($latitude, $row['latitude']);
    array_push($longitude, $row['longitude']);
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
  <script src="pace.js"></script>
  <link href="pace-theme-loading-bar.css" rel="stylesheet" />
</head>
<style>
body > :not(.pace),body:before,body:after {
  -webkit-transition:opacity .4s ease-in-out;
  -moz-transition:opacity .4s ease-in-out;
  -o-transition:opacity .4s ease-in-out;
  -ms-transition:opacity .4s ease-in-out;
  transition:opacity .4s ease-in-out
}

body:not(.pace-done) > :not(.pace),body:not(.pace-done):before,body:not(.pace-done):after {
  opacity:0
}
body{
  background-color:#F3EFE0;
}
.glyphicon {
    font-size: 20px;
}
.navbar{
  font-size:20px;
}
.nav>li>a:hover {
    text-decoration: none;
    background-color: blue;
}
</style>
<body>
  <nav class="navbar" style="background-color:#00BFFF;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a style="color:white;font-weight:bold;font-size:20px;background-color:#00BFFF;" class="navbar-brand">Welcome, <?php echo $_SESSION['user_firstname']; ?></a>
      </div>
      <ul class="nav navbar-nav">
        <li><a style="color:white;background-color:#00BFFF;" href="main.php">Home</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="friends.php">Friends</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="interests.php">Interests</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="group.php">Groups</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--same as"index.php?logout=true" -->
        <li><a style="color:white;margin-top:-4px;background-color:#00BFFF;" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
      </ul>
    </div>
  </nav>
<div class="panel panel-info" style="margin-top:20px;">
  <div class=panel-heading style = "text-align:center;">
    <h2 class=form-signin-heading><?php echo $groupName[0];?>'s Event: <?php echo $title[0];?></h2>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Description</b>: <?php echo $description[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Start Time</b>: <?php echo $startTime[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event End Time</b>: <?php echo $endTime[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Location</b>: <?php echo $locationName[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Address</b>: <?php echo $eventAddress[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Location Description</b>: <?php echo $eventDescription[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Location Latitude</b>: <?php echo $latitude[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Event Location Longitude</b>: <?php echo $longitude[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;;text-align:center;"><b>Event Zip Code</b>: <?php echo $zipcode[0];?>
  </div>

</div>
<div class="col-md-12">
    <button class="btn btn-lg btn-primary btn-block" onclick=signUp() id="signUpButton" style="margin-top:0px;width:400px;margin-left:auto;margin-right:auto;" name="login">Sign Up For This Event</button>
      <br>
 <div id="signUpMessage" style="width:400px;margin-left:auto;margin-right:auto;font-size:16px;text-align:center;font-weight:bold;">
   <br>
 </div>
</div>
<div style = "overflow-y: hidden; overflow-x: scroll; width:95%;white-space: nowrap;height:385px;margin-left:auto;margin-right:auto;border:3px solid #000000;" >
<?php
  $select_image="SELECT * FROM photo WHERE p_id IN (SELECT p_id FROM photo_of WHERE event_id='" . $eventid . "');";
  $var = $connection->query($select_image);
  while($row=$var->fetch_assoc()){
    echo '<span style="width:500px;display:inline-block;"><a class="thumbnail" style ="text-decoration:none"><img class="img-responsive" style="height:300px;" src = "data:image/jpg;base64,' . base64_encode($row['image']) . '" alt="No Image">';
    echo '<div> Title: ' . $row['name'] . '</div><div style="text-decoration:none"> Caption: ' . $row['caption'] . '</div></a></span>';
  }

?>
</div>

<div class="row" style="width:100%;">
  <div class="col-md-12" style="margin-bottom:50px;">
  <form name="frmImage" style = "width:500px;margin-left:auto;margin-right:auto;margin-top:20px;" enctype="multipart/form-data" action="imageProcessing.php" method="post">
  <label>Upload An Image:</label><br/>
    <label class="sr-only" for="photo_name">Photo Name</label>
    <input class="form-control" style = "height:45px;" placeholder="Photo Name" id="photo_name" class="login_input" type="text" name="photo_name"  required autofocus autocomplete="off" />
    <br>
    <label class="sr-only" for="photo_name">Caption</label>
    <input class="form-control" style = "height:45px;" placeholder="Photo Caption" id="photo_caption" class="login_input" type="text" name="photo_caption"  required autofocus autocomplete="off" />
    <br>
    <input name="userImage" type="file" class="inputFile" required/>
    <br>
    <input name="eventid" type="hidden" class="inputFile" value="<?php echo $eventid;?>"/>
     <input name="username" type="hidden" class="inputFile" value="<?php echo $_SESSION['user_name'];?>">
  <input class="btn btn-primary btn-block" type="submit" value="Upload" class="btnSubmit" />
  </form>
  <div id="uploadErrorMsg" style="width:300px;margin-left:auto;margin-right:auto;font-size:16px;text-align:center;font-weight:bold;">
    <?php
      if(isset($_SESSION['uploadErrorMsg'])){
        echo $_SESSION['uploadErrorMsg'];
        unset($_SESSION['uploadErrorMsg']);
      }
    ?>
  </div>
  </div>
  <div class="col-md-6" style="border:1px solid #e3e3e3;border-radius:4px;">

      <h3 class="form-signin-heading" style="margin-left:auto;margin-right:auto;text-align:center;">People who are going to this event</h3>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <input type="search" id="search" value="" class="form-control" style="text-align:center" placeholder="Search">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody id = "tableBody">

                    </tbody>
                </table>
                <hr>
            </div>
        </div>

</div>



  <div class="col-md-6" >
    <div id="ratingErrorMsg" style="width:300px;margin-left:auto;margin-right:auto;font-size:16px;text-align:center;font-weight:bold;">
      <?php
        if(isset($_SESSION['RatingSubmitMsg'])){
          echo $_SESSION['RatingSubmitMsg'];
          unset($_SESSION['RatingSubmitMsg']);
        }
      ?>
    </div>
    <form class="form-signin" method="post" action="SubmitRating.php" name="" style="margin-left:auto;margin-right:auto;border:1px solid #e3e3e3;border-radius:4px;background-color:#f5f5f5;width:500px;height:150px;">
      <h3 class="form-signin-heading" style="margin-left:auto;margin-right:auto;text-align:center;">Rate This Event: <input type="number" id="event_rating" name="event_rating" min="1" max="5" required>&nbsp;Stars</h3>
      <input class="form-control" id="rating_username" class="login_input" type="text" style="display:none;" name="rating_username" autocomplete="off" autofocus required />
      <br>
      <button class="btn btn-primary btn-block" style = "width:150px;height:40px;;text-align:center;margin-left:auto;margin-right:auto;" type="submit" id="submitRatingButton" name="login">Submit Rating</button>
    </form>
  </div>
</div>
<a style="display:none;" id="current_user"><?php echo $_SESSION['user_name']; ?></a>
<a style="display:none;" id="event_start_time"><?php echo $startTime[0]; ?></a>

<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script src="javascripts/bootstrap-rating-input.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(this).scrollTop(0);
document.getElementById('rating_username').value = document.getElementById('current_user').innerHTML;

var EventStartDateTime = new Date(document.getElementById('event_start_time').innerHTML);
var dateNow = new Date();
if(dateNow < EventStartDateTime){
  document.getElementById("event_rating").disabled = true;
  document.getElementById("submitRatingButton").disabled = true;
  document.getElementById('ratingErrorMsg').innerHTML = "This event has not start yet.";
}



  $(function () {
    $( '#table' ).searchable({
        searchType: 'default'
    });
});


var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];
var firstname = [];
var lastname = [];
var email = [];
<?php
$firstname = array();
$lastname = array();
$email = array();
if (!$connection->connect_errno) {
  $sql = "SELECT firstname,lastname,email FROM sign_up NATURAL JOIN member WHERE event_id = '" . $_SESSION['event_page_eventid'] . "';";
  $query= $connection->query($sql);
  while($row = $query->fetch_assoc()){
    array_push($firstname, $row['firstname']);
    array_push($lastname, $row['lastname']);
    array_push($email, $row['email']);
  }
}
?>
firstname = <?php echo json_encode($firstname) ?>;
lastname = <?php echo json_encode($lastname) ?>;
email = <?php echo json_encode($email) ?>;
for(var i = 0; i < firstname.length; i++){
  var newRow   = tableRef.insertRow(tableRef.rows.length);
  var newCell1  = newRow.insertCell(0);
  var newCell2  = newRow.insertCell(1);
  var newCell3  = newRow.insertCell(2);
  var newText1  = document.createTextNode(firstname[i]);
  var newText2  = document.createTextNode(lastname[i]);
  var newText3  = document.createTextNode(email[i]);
  newCell1.appendChild(newText1);
  newCell2.appendChild(newText2);
  newCell3.appendChild(newText3);
}


});

function signUp(){
  <?php
  $eventGroupMembers = array();
  if (!$connection->connect_errno) {
    $sql = "SELECT username FROM belongs_to WHERE group_id = '" . $groupid[0] . "';";
    $query= $connection->query($sql);
    while($row = $query->fetch_assoc()){
      array_push($eventGroupMembers, $row['username']);
    }
  }
   ?>

   var eventGroupMembers = [];
   var isInGroup = false;
   eventGroupMembers = <?php echo json_encode($eventGroupMembers); ?>;
   for(var i = 0; i < eventGroupMembers.length; i++){
     if(eventGroupMembers[i] == document.getElementById('current_user').innerHTML){
       isInGroup = true;
       $.ajax({
           type: 'POST',
           url: 'eventSignUpProcessing.php',
           data: { eventId: <?php echo $_SESSION['event_page_eventid']; ?>, uname: document.getElementById('current_user').innerHTML },
           success: function(response) {
             console.log(response)
             if(response == "Passed"){
               document.getElementById('signUpMessage').innerHTML = "Sign up failed. Event has passed.";
             }else{
             document.getElementById('signUpMessage').innerHTML = "You have signed up for this event.";
           }
           }
       });
     }
   }
   if(!isInGroup){
     document.getElementById('signUpMessage').innerHTML = "Sign Up Failed. Please Join This Group First";
   }
}

</script>
</body>
</html>
