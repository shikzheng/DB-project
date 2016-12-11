<?php
session_start();
if(!isset($_SESSION['user_login_status'])){
  header("Location: index.php");
}
 require_once("config/db.php");
 $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
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
<body style = "overflow-x:hidden;">
  <nav class="navbar" style="background-color:#00BFFF;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a style="color:white;font-weight:bold;font-size:20px;background-color:#00BFFF;" class="navbar-brand">Welcome, <?php echo $_SESSION['user_firstname']; ?></a>
      </div>
      <ul class="nav navbar-nav">
        <li><a style="color:yellow;background-color:#00BFFF;" href="main.php">Home</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="friends.php">Friends</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="interests.php">Interests</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="group.php">Groups</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a style="color:white;margin-top:-4px;background-color:#00BFFF;" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
      </ul>
    </div>
  </nav>


  <div class="row">
    <div class="col-md-12">
      <div style="border:1px solid #e3e3e3;border-radius:4px;margin-left:auto;margin-right:auto;background-color:#f5f5f5;">
          <h2 class="form-signin-heading" style="text-align:center;">Events you've signed up for in the next 3 days</h2>
          <div class="row">
              <div class="col-lg-4 col-lg-offset-4">
                <input type="search" id="search" value="" class="form-control" style="text-align:center;" placeholder="Search Group Events">
              </div>
          </div>
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
                          </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
                  <hr>
              </div>
          </div>
        </div>

        <div style="border:1px solid #e3e3e3;border-radius:4px;margin-left:auto;margin-right:auto;background-color:#f5f5f5;margin-top:20px;">
            <h2 class="form-signin-heading" style="text-align:center;">Events you've not signed up for in the next 3 days</h2>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                  <input type="search" id="searchNot" value="" class="form-control" style="text-align:center;" placeholder="Search Group Events">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped" id="EventTableNotSignUp">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location Name</th>
                                <th>Zip Code</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
          </div>


    <div style="margin-top:2%;text-algin:center;margin-bottom:30px;">
     <h2 class="form-signin-heading" style="text-align:center;">Your Images</h2>
       <div style = "overflow-y: hidden; overflow-x: scroll; width:95%;background-color:#f5f5f5;white-space: nowrap;height:400px;margin-left:auto;margin-right:auto;border:3px solid #000000;" >
      <?php
         $select_image="SELECT * FROM photo NATURAL JOIN photo_of NATURAL JOIN an_event WHERE p_id IN (SELECT p_id FROM photo WHERE username ='" . $_SESSION['user_name'] . "');";
         $var = $connection->query($select_image);
        while($row=$var->fetch_assoc()){
           echo '<span style="width:500px;display:inline-block;"><a class="thumbnail" data-toggle="tooltip" data-placement="top" title="Click me to go to Event Page of this Image!" href="eventPage.php?event_page_eventid=' . $row['event_ID'] . '" style ="text-decoration:none"><img class="img-responsive" style="height:300px;" src = "data:image/jpg;base64,' . base64_encode($row['image']) . '" alt="No Image">';
           echo '<div> Event: ' . $row['title'] . '</div><div> Title: ' . $row['name'] . '</div><div style="text-decoration:none"> Caption: ' . $row['caption'] . '</div></a></span>';
         }
      ?>
       </div>
    </div>
      </div>
    </div>


    <a style="display:none;" id="current_user"><?php echo $_SESSION['user_name']; ?></a>

<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  username = document.getElementById('current_user').innerHTML;
  $.ajax({
      type: 'POST',
      url: 'homeProcessing.php',
      data: { username:username},
      success: function(response) {
        var tableRef2 = document.getElementById('EventTable').getElementsByTagName('tbody')[0];

        var eventId = response.split('#')[0]
        var eventIdArr = [];
        for(i = 0; i<(eventId.replace(/[^,]/g, "").length+1); i++){
            eventIdArr[i] = eventId.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }
        var eventTitle = response.split('#')[1];
        var eventTitleArr = [];
        for(i = 0; i<(eventTitle.replace(/[^,]/g, "").length+1); i++){
            eventTitleArr[i] = eventTitle.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }

        var eventDescription = response.split('#')[2];
        var eventDescriptionArr = [];
        for(i = 0; i<(eventDescription.replace(/[^,]/g, "").length+1); i++){
            eventDescriptionArr[i] = eventDescription.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventStart = response.split('#')[3];
        var eventStartArr = [];
        for(i = 0; i<(eventStart.replace(/[^,]/g, "").length+1); i++){
            eventStartArr[i] = eventStart.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventEnd = response.split('#')[4];
        var eventEndArr = [];
        for(i = 0; i<(eventEnd.replace(/[^,]/g, "").length+1); i++){
            eventEndArr[i] = eventEnd.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventLocationName = response.split('#')[5];
        var eventLocationNameArr = [];
        for(i = 0; i<(eventLocationName.replace(/[^,]/g, "").length+1); i++){
            eventLocationNameArr[i] = eventLocationName.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventZipCode = response.split('#')[6];
        var eventZipCodeArr = [];
        for(i = 0; i<(eventZipCode.replace(/[^,]/g, "").length+1); i++){
            eventZipCodeArr[i] = eventZipCode.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }

          for(var i = 0; i < eventIdArr.length; i++){
            var newRow   = tableRef2.insertRow(tableRef2.rows.length);
            newRow.setAttribute( "onClick", "SelectedEvent(" + eventIdArr[i] + ")");
            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4  = newRow.insertCell(3);
            var newCell5  = newRow.insertCell(4);
            var newCell6  = newRow.insertCell(5);

            var newText1  = document.createTextNode(eventTitleArr[i]);
            var newText2  = document.createTextNode(eventDescriptionArr[i]);
            var newText3  = document.createTextNode(eventStartArr[i]);
            var newText4  = document.createTextNode(eventEndArr[i]);
            var newText5  = document.createTextNode(eventLocationNameArr[i]);
            var newText6  = document.createTextNode(eventZipCodeArr[i]);

            newCell1.appendChild(newText1);
            newCell2.appendChild(newText2);
            newCell3.appendChild(newText3);
            newCell4.appendChild(newText4);
            newCell5.appendChild(newText5);
            newCell6.appendChild(newText6);
          }

      }
  });

  $.ajax({
      type: 'POST',
      url: 'homeProcessing2.php',
      data: { username:username},
      success: function(response) {
        var tableRef2 = document.getElementById('EventTableNotSignUp').getElementsByTagName('tbody')[0];

        var eventId = response.split('#')[0]
        var eventIdArr = [];
        for(i = 0; i<(eventId.replace(/[^,]/g, "").length+1); i++){
            eventIdArr[i] = eventId.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }
        var eventTitle = response.split('#')[1];
        var eventTitleArr = [];
        for(i = 0; i<(eventTitle.replace(/[^,]/g, "").length+1); i++){
            eventTitleArr[i] = eventTitle.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }

        var eventDescription = response.split('#')[2];
        var eventDescriptionArr = [];
        for(i = 0; i<(eventDescription.replace(/[^,]/g, "").length+1); i++){
            eventDescriptionArr[i] = eventDescription.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventStart = response.split('#')[3];
        var eventStartArr = [];
        for(i = 0; i<(eventStart.replace(/[^,]/g, "").length+1); i++){
            eventStartArr[i] = eventStart.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventEnd = response.split('#')[4];
        var eventEndArr = [];
        for(i = 0; i<(eventEnd.replace(/[^,]/g, "").length+1); i++){
            eventEndArr[i] = eventEnd.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventLocationName = response.split('#')[5];
        var eventLocationNameArr = [];
        for(i = 0; i<(eventLocationName.replace(/[^,]/g, "").length+1); i++){
            eventLocationNameArr[i] = eventLocationName.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }


        var eventZipCode = response.split('#')[6];
        var eventZipCodeArr = [];
        for(i = 0; i<(eventZipCode.replace(/[^,]/g, "").length+1); i++){
            eventZipCodeArr[i] = eventZipCode.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }

          for(var i = 0; i < eventIdArr.length; i++){
            var newRow   = tableRef2.insertRow(tableRef2.rows.length);
            newRow.setAttribute( "onClick", "SelectedEvent(" + eventIdArr[i] + ")");
            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4  = newRow.insertCell(3);
            var newCell5  = newRow.insertCell(4);
            var newCell6  = newRow.insertCell(5);

            var newText1  = document.createTextNode(eventTitleArr[i]);
            var newText2  = document.createTextNode(eventDescriptionArr[i]);
            var newText3  = document.createTextNode(eventStartArr[i]);
            var newText4  = document.createTextNode(eventEndArr[i]);
            var newText5  = document.createTextNode(eventLocationNameArr[i]);
            var newText6  = document.createTextNode(eventZipCodeArr[i]);

            newCell1.appendChild(newText1);
            newCell2.appendChild(newText2);
            newCell3.appendChild(newText3);
            newCell4.appendChild(newText4);
            newCell5.appendChild(newText5);
            newCell6.appendChild(newText6);
          }

      }
  });



  $(document).ajaxStop(function () {
    $(function () {
      $( '#EventTable' ).searchable({
          searchType: 'default'
      });
      $( '#EventTableNotSignUp' ).searchable({
          searchField: '#searchNot',
          searchType: 'default'
      });
  });
  });
});
function SelectedEvent(eventid){
window.location.href = "eventPage.php?event_page_eventid="+eventid;
}
</script>
</body>
</html>
