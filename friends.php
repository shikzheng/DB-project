<?php
session_start();
if(!isset($_SESSION['user_login_status'])){
  header("Location: index.php");
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
<style>
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
body{
  background-color:#F3EFE0;
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
        <li><a style="color:yellow;background-color:#00BFFF;" href="friends.php">Friends</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="interests.php">Interests</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="group.php">Groups</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--same as"index.php?logout=true" -->
        <li><a style="color:white;margin-top:-4px;background-color:#00BFFF;" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
      </ul>
    </div>
  </nav>
  <div class="row">
    <div class="col-md-12" style="text-align:center;margin-left:auto;margin-right:auto;margin-top:20px;">
      <div style="width:450px;height:230px;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#f5f5f5;margin-left:auto;margin-right:auto;">
      <form class="form-signin" method="post" action="AddFriendProcessing.php" name="" style="width:80%;margin-left:auto;margin-right:auto;">
          <h2 class="form-signin-heading">Add a friend</h2>
          <label class="sr-only" for="addFriend_username">Username</label>
          <input class="form-control" style = "height:45px;" placeholder="Username" id="addFriend_username" class="login_input" type="text" name="addFriend_username" autocomplete="off" autofocus required />
          <br>
          <br>
          <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Add Friend</button>
      </form>
      <div>
        <?php
          if(isset($_SESSION['AddFriendErrorMsg'])){
            echo $_SESSION['AddFriendErrorMsg'];
            unset($_SESSION['AddFriendErrorMsg']);
          }
        ?>
      </div>
    </div>
    </div>
    <div class="col-md-12" style="margin-top:40px;">
    <div class="col-md-6">
      <div style="border:1px solid #e3e3e3;border-radius:4px;margin-left:auto;margin-right:auto;background-color:#f5f5f5;">
        <h2 class="form-signin-heading">My friends</h2>
          <div class="row">
              <div class="col-lg-12">
                  <table class="table table-striped" id="table">
                      <thead>
                          <tr>
                              <th>Username</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Email</th>
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

  <div class="col-md-6">
    <div style="border:1px solid #e3e3e3;border-radius:4px;margin-left:auto;margin-right:auto;background-color:#f5f5f5;">
        <h2 class="form-signin-heading" style="text-align:center;">Group events friends are attending in the next 3 days</h2>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
              <input type="search" id="searchEvent" value="" class="form-control" style="text-align:center;" placeholder="Search Group Events">
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
    </div>
    </div>
</div>


  <a style="display:none;" id="current_user"><?php echo $_SESSION['user_name']; ?></a>
</div>

<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];


  $.ajax({
      type: 'POST',
      url: 'friendProcessing.php',
      data: { currUser: document.getElementById('current_user').innerHTML },
      success: function(response) {
        var firstName = response.split('#')[0];
        var firstNameArr = [];
        for(i = 0; i<(firstName.replace(/[^,]/g, "").length+1); i++){
            firstNameArr[i] = firstName.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }

        var lastName = response.split('#')[1];
        var lastNameArr = [];
        for(i = 0; i<(lastName.replace(/[^,]/g, "").length+1); i++){
            lastNameArr[i] = lastName.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }

        var email = response.split('#')[2];
        var emailArr = [];
        for(i = 0; i<(email.replace(/[^,]/g, "").length+1); i++){
            emailArr[i] = email.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
          }
          var username = response.split('#')[3];
          var usernameArr = [];
          for(i = 0; i<(username.replace(/[^,]/g, "").length+1); i++){
              usernameArr[i] = username.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
            }
          for(var i = 0; i < firstNameArr.length; i++){
            var newRow   = tableRef.insertRow(tableRef.rows.length);
            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4  = newRow.insertCell(3);

            var newText1  = document.createTextNode(usernameArr[i]);
            var newText2  = document.createTextNode(firstNameArr[i]);
            var newText3  = document.createTextNode(lastNameArr[i]);
            var newText4  = document.createTextNode(emailArr[i]);

            newCell1.appendChild(newText1);
            newCell2.appendChild(newText2);
            newCell3.appendChild(newText3);
            newCell4.appendChild(newText4);

          }

          /*--------------------------*/
          $.ajax({
              type: 'POST',
              url: 'friendProcessing2.php',
              data: { usernameArr:usernameArr},
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
      }
  });
});
function SelectedEvent(eventid){
window.location.href = "http://localhost/Findfolks/eventPage.php?event_page_eventid="+eventid;
}

</script>
</body>
</html>
