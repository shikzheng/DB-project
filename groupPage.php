<?php
session_start();
if (isset($_GET['group_page_groupid'])){
$_SESSION['group_page_groupid'] = $_GET['group_page_groupid'];
}
if(!isset($_SESSION['user_login_status'])){
  header("Location: index.php");
}else if (!isset($_GET['group_page_groupid']) && !isset($_SESSION['group_page_groupid'])){
  header("Location: group.php");
}
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$groupid =  $_SESSION['group_page_groupid'];
$groupName = array();
$category = array();
$keywords = array();
$description = array();
$creator = array();
$members = array();
$authorized = array();
$categoryString = "";
$keyWordString = "";
if (!$connection->connect_errno) {
  $sql = "SELECT category,keyword FROM about WHERE group_id = ?";
  $query= $connection->prepare($sql);
  $query->bind_param("i", $groupid);
  $query->execute();
  $query->bind_result($cat,$keyW);
  if (!$query) {
    printf("Errormessage: %s\n", $connection->error);
  }
  while($query->fetch()){
    array_push($category, $cat);
    array_push($keywords, $keyW);
  }
  if(count($category)==1){
    $categoryString = $category[0];
  }else{
  for($i = 0; $i < count($category);$i++){
    if($i == 0){
      $categoryString = $category[0];
    }else{
    $categoryString = $categoryString . ', ' . $category[$i];
   }
  }
 }


 if(count($keywords)==1){
   $keyWordString = $keywords[0];
 }else{
 for($i = 0; $i < count($keywords);$i++){
   if($i == 0){
     $keyWordString = $keywords[0];
   }else{
   $keyWordString = $keyWordString . ', ' . $keywords[$i];
  }
 }
}

}

if (!$connection->connect_errno) {
  $sql = "SELECT group_name,description,creator,username,authorized FROM belongs_to NATURAL JOIN a_group WHERE group_id = ?";
  $query= $connection->prepare($sql);
  $query->bind_param("i", $groupid);
  $query->execute();
  $query->bind_result($gn,$des,$cre,$userN,$autho);
  if (!$query) {
    printf("Errormessage: %s\n", $connection->error);
  }
  while($query->fetch()){
    array_push($groupName, $gn);
    array_push($description, $des);
    array_push($creator, $cre);
    array_push($members, $userN);
    array_push($authorized, $autho);
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
    <h2 class=form-signin-heading>Welcome to <?php echo $groupName[0];?>!</h2>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Group Description</b>: <?php echo $description[0];?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;border-bottom:1px solid #bce8f1;text-align:center;"><b>Group Category</b>: <?php echo $categoryString;?>
  </div>
  <div class=panel-body style="font-size:16px;background-color:#FFFFFF;text-align:center;border-bottom:1px solid #bce8f1;"><b>Group Keywords</b>: <?php echo $keyWordString;?>
  </div>
  <div style="margin-left:auto;margin-right:auto;width:450px;margin-top:8px;height:auto;text-align:center;">
      <form class="form-signin" method="post" action="GroupPageJoinGroupProcessing.php" name="" style="width:80%;margin-left:auto;margin-right:auto;">
          <input class="form-control" style = "height:45px;display:none;" placeholder="Group Name" id="creategroup_GroupName" value = "<?php echo $groupName[0];?>" class="login_input" type="text" name="joingroup_GroupName" autocomplete="off" autofocus required />
          <input class="form-control" style = "height:45px;display:none;" placeholder="Group Name" id="joingroup_GroupId" value = "<?php echo $groupid;?>" class="login_input" type="text" name="joingroup_GroupId" autocomplete="off" autofocus required />
          <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Join Group</button>
      </form>
      <div>
        <?php
          if(isset($_SESSION['JoinGroupErrorMsg2'])){
            echo $_SESSION['JoinGroupErrorMsg2'];
            unset($_SESSION['JoinGroupErrorMsg2']);
          }
        ?>
      </div>
 </div>
</div>
<div class="row" style="width:100%;">
  <div class="col-md-4" id="authorizedOnly2">
    <div style="width:auto;height:auto;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#FFFFFF;text-align:center;">
              <h2 class="panel-heading" style="font-size:20px;">Group Members</h2>
              <input type="search" id="memberSearch" value="" class="form-control" style = "width:200px;margin-left:auto;margin-right:auto;text-align:center;" placeholder="Search Member">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th id = "AuthorizedColumn">Authorized</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <hr>
  </div>
  <br>
    <button class="btn btn-lg btn-primary btn-block" onclick=authorizeProcessSubmitClick() id="AuthorizeButton" style="width:300px;margin-left:auto;margin-right:auto;">Submit</button>
    <br>
    <div style = "width:300px;margin-left:auto;margin-right:auto;font-size:16px;text-align:center;font-weight:bold;" id = "AuthorizeProcessMessage">

    </div>
</div>

  <div class="col-md-4" id = "authorizedOnly" style="border:1px solid #e3e3e3;border-radius:4px;background-color:#f5f5f5;">


    <form class="form-signin" method="post" action="createEventProcessing.php" style="width:90%;margin-left:auto;margin-right:auto;">
        <h3 class="form-signin-heading" style = "margin-left:auto;margin-right:auto;text-align:center;">Create an Event</h3>
        <label class="sr-only" for="createEvent_Title">Title</label>
        <input class="form-control"  value = "<?php if((isset($_SESSION["createEvent_Title"]) && (isset($_SESSION["createEventErrorMsg"])) && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Title"];} ?>"
        style = "height:45px;" placeholder="Title" id="createEvent_Title" class="login_input" type="text" name="createEvent_Title" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_Description">Description</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_Description"]) && (isset($_SESSION["createEventErrorMsg"])) && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Description"];} ?>"
         style = "height:45px;" placeholder="Description" id="createEvent_Description" class="login_input" type="text" name="createEvent_Description" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_StartTime">Start Time</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_StartTime"]) && (isset($_SESSION["createEventErrorMsg"])) && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_StartTime"];} ?>"
         style = "height:45px;" placeholder="Start Time" id="createEvent_StartTime" class="login_input" type="datetime-local" name="createEvent_StartTime" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_EndTime">End Time</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_EndTime"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_EndTime"];} ?>"
         style = "height:45px;" placeholder="End Time" id="createEvent_EndTime" class="login_input" type="datetime-local" name="createEvent_EndTime" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_Location_Name">Location Name</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_Location_Name"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Location_Name"];} ?>"
         style = "height:45px;" placeholder="Location Name" id="createEvent_Location_Name" class="login_input" type="text" name="createEvent_Location_Name" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_Location_Address">Location Address</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_Location_Address"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Location_Address"];} ?>"
         style = "height:45px;" placeholder="Location Address" id="createEvent_Location_Address" class="login_input" type="text" name="createEvent_Location_Address" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_Location_Description">Location Description</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_Location_Description"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Location_Description"];} ?>"
         style = "height:45px;" placeholder="Location Description" id="createEvent_Location_Description" class="login_input" type="text" name="createEvent_Location_Description" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_Location_Latitude">Location Latitude</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_Location_Latitude"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Location_Latitude"];} ?>"
         style = "height:45px;" placeholder="Location Latitude" id="createEvent_Location_Latitude" class="login_input" type="text" name="createEvent_Location_Latitude" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_Location_Longitude">Location Longitude</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_Location_Longitude"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_Location_Longitude"];} ?>"
         style = "height:45px;" placeholder="Location Longitude" id="createEvent_Location_Longitude" class="login_input" type="text" name="createEvent_Location_Longitude" autocomplete="off" autofocus required />
        <label class="sr-only" for="createEvent_ZipCode">Zip Code</label>
        <input class="form-control" value = "<?php if((isset($_SESSION["createEvent_ZipCode"])&& (isset($_SESSION["createEventErrorMsg"]))  && ($_SESSION['createEventErrorMsg'] != "Success! The event has been created."))){ echo $_SESSION["createEvent_ZipCode"];} ?>"
         style = "height:45px;" placeholder="Zip Code" id="createEvent_ZipCode" class="login_input" type="text" name="createEvent_ZipCode" autocomplete="off" autofocus required />
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Create Event</button>
    </form>
    <div style="margin-left:auto;margin-right:auto;font-size:16px;text-align:center;font-weight:bold;">
      <?php
        if(isset($_SESSION['createEventErrorMsg'])){
          echo $_SESSION['createEventErrorMsg'];
          unset($_SESSION['createEventErrorMsg']);
        }
      ?>
    </div>
  </div>
  <div class="col-md-4">


    <div style="width:auto;height:auto;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#FFFFFF;text-align:center;">
        <h2 class="panel-heading" style="font-size:20px;">Group Events</h2>
        <input type="search" id="search" value="" class="form-control" style = "width:200px;margin-left:auto;margin-right:auto;text-align:center;" placeholder="Search Group Events">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped" id="EventTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Location Name</th>
                            <th>Zip Code</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <hr>
            </div>
        </div>
  </div>
  </div>
  <a style="display:none;" id="current_user"><?php echo $_SESSION['user_name']; ?></a>
  <form id = "event_page_hidden_form" class="form-signin" method="get" action="eventPage.php" style = "display:none;" name="">
      <label class="sr-only" for="event_page_eventid"></label>
      <input class="form-control" id="event_page_eventid" class="login_input" type="text" name="event_page_eventid" autocomplete="off" autofocus required />
      <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login"></button>
  </form>

  </div>
</div>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    $(function () {
      $( '#EventTable' ).searchable({
          searchType: 'default'
      });
      $( '#table' ).searchable({
          searchField: '#memberSearch',
          searchType: 'default'
      });

  });

      var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];
      var username = [];
      var firstname = [];
      var lastname = [];
      var email = [];
      var allUserInGroup = [];
      var groupCreator = [];
      <?php
      $theusername = array();
      $firstname = array();
      $lastname = array();
      $email = array();
      $AllUsername = array();
      if (!$connection->connect_errno) {
        $sql = "SELECT username,firstname,lastname,email,username FROM member NATURAL JOIN belongs_to WHERE group_id = ?";
        $query= $connection->prepare($sql);
        $query->bind_param("i", $groupid);
        $query->execute();
        $query->bind_result($userN,$fn,$ln,$em,$userN2);
        while($query->fetch()){
          array_push($theusername, $userN);
          array_push($firstname, $fn);
          array_push($lastname, $ln);
          array_push($email, $em);
          array_push($AllUsername, $userN2);
        }
      }
      ?>
      username = <?php echo json_encode($theusername) ?>;
      firstname = <?php echo json_encode($firstname) ?>;
      lastname = <?php echo json_encode($lastname) ?>;
      email = <?php echo json_encode($email) ?>;
      allUserInGroup = <?php echo json_encode($AllUsername); ?>;
      groupCreator = <?php echo json_encode($creator); ?>;
      for(var i = 0; i < username.length; i++){
        var newRow   = tableRef.insertRow(tableRef.rows.length);
        //newRow.setAttribute( "onClick", "SelectedGroup(" + groupid[i] + ")");
        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4  = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);

        var newText1  = document.createTextNode(username[i]);
        var newText2  = document.createTextNode(firstname[i]);
        var newText3  = document.createTextNode(lastname[i]);
        var newText4  = document.createTextNode(email[i]);

        var checkBox = document.createElement("input");
        checkBox.id = "checkBox"+i;
        checkBox.type = "checkbox";
        if(allUserInGroup[i]==groupCreator[0]){
          checkBox.disabled = true;
        }

        newCell1.appendChild(newText1);
        newCell2.appendChild(newText2);
        newCell3.appendChild(newText3);
        newCell4.appendChild(newText4);
        newCell5.appendChild(checkBox);
        }

      var authorizedArr = <?php echo json_encode($authorized); ?>;
      for(var i = 0; i < authorizedArr.length; i++){
        if(authorizedArr[i]==1){
          document.getElementById("checkBox"+i).checked = true;
        }
      }



  var authorize = <?php echo json_encode($authorized) ?>;
  var members = <?php echo json_encode($members) ?>;
  var authorized = 0;
  var found = 0;
  for(var i = 0; i < members.length; i++){
    if(members[i]==document.getElementById('current_user').innerHTML){
      found = 1;
    }
  }
  if(found != 1){
    var elem = document.getElementById("authorizedOnly");
    elem.remove();
    }else{
    var index = 0;
    for(var i = 0; i < members.length; i++){
      if(members[i]==document.getElementById('current_user').innerHTML){
        index = i;
      }
    }
    authorized = authorize[index];
    if(authorized == 0){
      var elem = document.getElementById("authorizedOnly");
      elem.remove();
      }
  }
  var theCreator = <?php echo json_encode($creator) ?>;
  if(theCreator[0]!=document.getElementById('current_user').innerHTML){
    var elem3 = document.getElementById("AuthorizeProcessMessage");
    var elem4 = document.getElementById("AuthorizedColumn");
    var elem2 = document.getElementById("AuthorizeButton");
    elem3.remove();
    elem4.remove();
    elem2.remove();
    for(var i = 0; i < authorize.length; i++){
      var element = document.getElementById("checkBox"+i);
      element.remove();
    }
  }


    var tableRef = document.getElementById('EventTable').getElementsByTagName('tbody')[0];
    var title2 = [];
    var description2 = [];
    var startTime2 = [];
    var endTime2 = [];
    var locationName2 = [];
    var zipcode2 = [];
    var eventid = [];
    var queryEventId = [];
    var NumRating = [];
    var AEventRating = [];
    <?php
    $title2 = array();
    $description2 = array();
    $startTime2 = array();
    $endTime2 = array();
    $locationName2 = array();
    $zipcode2 = array();
    $eventid = array();

    if (!$connection->connect_errno) {
      $sql = "SELECT title,description,start_time,end_time,location_name,zipcode,event_id FROM organize NATURAL JOIN an_event WHERE group_id = ?";
      $query= $connection->prepare($sql);
      $query->bind_param("i", $groupid);
      $query->execute();
      $query->bind_result($titl,$des,$st,$et,$loc,$zcode,$eid);
      while($query->fetch()){
        array_push($title2, $titl);
        array_push($description2, $des);
        array_push($startTime2, $st);
        array_push($endTime2, $et);
        array_push($locationName2, $loc);
        array_push($zipcode2, $zcode);
        array_push($eventid, $eid);
      }
    }
    $queryEventId = array();
    $NumRating = array();
    if (!$connection->connect_errno) {
      $sql = "SELECT event_id,count(*) as NumRating FROM sign_up NATURAL JOIN organize WHERE group_id = ? GROUP BY event_id";
      $query= $connection->prepare($sql);
      $query->bind_param("i", $groupid);
      $query->execute();
      $query->bind_result($eid,$count);
      while($query->fetch()){
        array_push($queryEventId, $eid);
        array_push($NumRating, $count);
      }
    }
    $AEventRating = array();
    if (!$connection->connect_errno) {
      $sql = "SELECT rating FROM sign_up NATURAL JOIN organize WHERE group_id = ?";
      $query= $connection->prepare($sql);
      $query->bind_param("i", $groupid);
      $query->execute();
      $query->bind_result($rate);
      while($query->fetch()){
        array_push($AEventRating, $rate);
      }
    }

    ?>
    title2 = <?php echo json_encode($title2); ?>;
    description2 = <?php echo json_encode($description2); ?>;
    startTime2 = <?php echo json_encode($startTime2); ?>;
    endTime2 = <?php echo json_encode($endTime2); ?>;
    locationName2 = <?php echo json_encode($locationName2); ?>;
    zipcode2 = <?php echo json_encode($zipcode2); ?>;
    eventid = <?php echo json_encode($eventid); ?>;
    queryEventId = <?php echo json_encode($queryEventId); ?>;
    NumRating = <?php echo json_encode($NumRating); ?>;
    AEventRating = <?php echo json_encode($AEventRating); ?>;
    console.log("WASSSS")
    console.log(queryEventId)
    console.log(NumRating)
    console.log(AEventRating)
    var final = [];
    for(var i = 0, j = 0; j < NumRating.length; i = i+parseInt(NumRating[i]), j++){
        final[j] = AEventRating.slice(i,parseInt(NumRating[j])+i);
    }
    var allEventAverageRating = [];
    for(var i = 0; i < final.length; i++){
      var average = 0;
      var total = 0;
      var denom = final[i].length;
      var countSix = 0;
      for(var j = 0; j < final[i].length; j++){
        if(parseFloat(final[i][j]) == 6){
          countSix++;
        }else{
          total = total + parseFloat(final[i][j]);
        }
      }
      if(countSix>0){
        denom = final[i].length - countSix;
      }
      average = total / denom;
      allEventAverageRating[i] = average;
    }
    for(var i = 0; i < allEventAverageRating.length; i++){
      if(allEventAverageRating[i] == 0){
        allEventAverageRating[i] = "No Rating";
        console.log("all")
        console.log(allEventAverageRating[i])
      }
    }
    console.log(allEventAverageRating)

    for(var i = 0; i < title2.length; i++){
      var newRow   = tableRef.insertRow(tableRef.rows.length);
      newRow.setAttribute( "onclick", "SelectedEvent(" + eventid[i] + ")");
      var newCell1  = newRow.insertCell(0);
      var newCell2  = newRow.insertCell(1);
      var newCell3  = newRow.insertCell(2);
      var newCell4  = newRow.insertCell(3);
      var newCell5  = newRow.insertCell(4);
      var newCell6  = newRow.insertCell(5);
      var newCell7  = newRow.insertCell(6);

      var newText1  = document.createTextNode(title2[i]);
      var newText2  = document.createTextNode(description2[i]);
      var newText3  = document.createTextNode(startTime2[i]);
      var newText4  = document.createTextNode(endTime2[i]);
      var newText5  = document.createTextNode(locationName2[i]);
      var newText6  = document.createTextNode(zipcode2[i]);
      var newText7  = document.createTextNode(allEventAverageRating[i]);

      newCell1.appendChild(newText1);
      newCell2.appendChild(newText2);
      newCell3.appendChild(newText3);
      newCell4.appendChild(newText4);
      newCell5.appendChild(newText5);
      newCell6.appendChild(newText6);
      newCell7.appendChild(newText7);

    }



});
function SelectedEvent(eventid){
  var input = document.getElementById('event_page_eventid');
  input.value = eventid;
  document.getElementById('event_page_hidden_form').submit();
}

function authorizeProcessSubmitClick(){

  var authorizedArr = <?php echo json_encode($authorized); ?>;
  for(var i = 0; i < authorizedArr.length; i++){
    if(document.getElementById("checkBox"+i).checked){
      authorizedArr[i] = 1;
    }else{
      authorizedArr[i] = 0;
    }
  }

  var members = <?php echo json_encode($members); ?>;
  var thisGroup = <?php echo $groupid; ?>;
  $.ajax({
      type: 'POST',
      url: 'AuthorizeProcessing.php',
      data: { authorizedArr:authorizedArr, members:members, thisGroup:thisGroup },
      success: function(response) {
        document.getElementById('AuthorizeProcessMessage').innerHTML = "Authorization Updated.";
      }
  });
}
</script>
</body>
</html>
