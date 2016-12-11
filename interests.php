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
        <li><a style="color:white;background-color:#00BFFF;" href="friends.php">Friends</a></li>
        <li><a style="color:yellow;background-color:#00BFFF;" href="#">Interests</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="group.php">Groups</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--same as"index.php?logout=true" -->
        <li><a style="color:white;margin-top:-4px;background-color:#00BFFF;" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
      </ul>
    </div>
  </nav>
  <div class="row" style="width:100%;">
    <div class="col-md-4">
      <div style="margin:auto;width:450px;height:290px;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#f5f5f5;">
      <form class="form-signin" method="post" action="addInterestProcessing.php" name="" style="width:90%;margin-left:auto;margin-right:auto;">
          <h2 class="form-signin-heading">Add an interest</h2>
          <label class="sr-only" for="addInterest_Category">Category</label>
          <input class="form-control"  value = "<?php if((isset($_SESSION["addInterest_Category"]) && (isset($_SESSION["addInterestErrorMsg"])) && ($_SESSION['addInterestErrorMsg'] != "Success! The interest has been added."))){ echo $_SESSION["addInterest_Category"];} ?>"
          style = "height:45px;" placeholder="Category" id="addInterest_Category" class="login_input" type="text" name="addInterest_Category" autocomplete="off" autofocus required />
          <br>
          <label class="sr-only" for="addInterest_Keyword">Keyword</label>
          <input class="form-control" value = "<?php if((isset($_SESSION["addInterest_Keyword"]) && (isset($_SESSION["addInterestErrorMsg"])) && ($_SESSION['addInterestErrorMsg'] != "Success! The interest has been added."))){ echo $_SESSION["addInterest_Keyword"];} ?>"
           style = "height:45px;" placeholder="Keyword" id="addInterest_Keyword" class="login_input" type="text" name="addInterest_Keyword" autocomplete="off" autofocus required />
          <br>
          <br>
          <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Add Interest</button>
      </form>
      <br>
      <br>
      <div>
        <?php
          if(isset($_SESSION['addInterestErrorMsg'])){
            echo $_SESSION['addInterestErrorMsg'];
            unset($_SESSION['addInterestErrorMsg']);

          }
        ?>
      </div>
      <br>
    </div>
    </div>




    <div class="col-md-4">
      <div style="width:1200px;height:auto;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#FFFFFF;">
      <div class="container">
        <h2 class="form-signin-heading">Events from groups with similar interest within 3 days</h2>
          <div class="row">
              <div class="col-lg-4 col-lg-offset-4">
                  <input type="search" id="search" value="" class="form-control" placeholder="Search">
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


  <div style="width:1200px;height:auto;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#FFFFFF;">
  <div class="container">
    <h2 class="form-signin-heading">All Interests</h2>
      <div class="row">
          <div class="col-lg-4 col-lg-offset-4">
              <input type="search" id="search2" value="" class="form-control" placeholder="Search">
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
              <table class="table table-striped" id="table">
                  <thead>
                      <tr>
                          <th>Category</th>
                          <th>Keywords</th>
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


  <form id = "group_page_hidden_form" class="form-signin" method="get" action="groupPage.php" style = "display:none;" name="">
      <label class="sr-only" for="group_page_groupid"></label>
      <input class="form-control" id="group_page_groupid" class="login_input" type="text" name="group_page_groupid" autocomplete="off" autofocus required />
      <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login"></button>
  </form>
  <a style="display:none;" id="current_user"><?php echo $_SESSION['user_name']; ?></a>

<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(function () {
    $( '#table' ).searchable({
        searchField: '#search2',
        searchType: 'default'
    });

});

  var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];
  var category = [];
  var keywords = [];
  <?php
      require_once("config/db.php");
      $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $category = array();
      $keywords = array();
      if (!$connection->connect_errno) {
        $sql = "SELECT category,keyword FROM interest;";
        $query= $connection->query($sql);
        while($row = $query->fetch_assoc()){
          array_push($category, $row['category']);
          array_push($keywords, $row['keyword']);
        }
      }
   ?>
  category = <?php echo json_encode($category) ?>;
  keywords = <?php echo json_encode($keywords) ?>;

  for(var i = 0; i < category.length; i++){
    var newRow   = tableRef.insertRow(tableRef.rows.length);
    var newCell1  = newRow.insertCell(0);
    var newCell2  = newRow.insertCell(1);
    var newText1  = document.createTextNode(category[i]);
    var newText2  = document.createTextNode(keywords[i]);
    newCell1.appendChild(newText1);
    newCell2.appendChild(newText2);
  }

/*---------------------------------------*/

var tableRef2 = document.getElementById('EventTable').getElementsByTagName('tbody')[0];
var eventTitle = [];
var eventDescription = [];
var eventStart = [];
var eventEnd = [];
var eventLocationName = [];
var eventZipCode = [];





$.ajax({
    type: 'POST',
    url: 'userInterestProcessing.php',
    data: { username:document.getElementById('current_user').innerHTML},
    success: function(response) {
      var category = response.split('#')[0]
      var categoryArr = [];
      for(i = 0; i<(category.replace(/[^,]/g, "").length+1); i++){
          categoryArr[i] = category.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
        }

      var keyword = response.split('#')[1]
      var keywordArr = [];
      for(i = 0; i<(keyword.replace(/[^,]/g, "").length+1); i++){
          keywordArr[i] = keyword.split(',')[i].replace("[",'').replace(/['"]+/g, '').replace("]",'').replace(/['\\/]+/g, '/');
        }
        console.log(categoryArr)
        console.log(keywordArr)

        $.ajax({
            type: 'POST',
            url: 'interestFilteredEventProcessing.php',
            data: { category:categoryArr, keyword:keywordArr},
            success: function(response) {
              console.log(categoryArr)
              console.log(keywordArr)
              
              console.log(response)
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

        $(document).ajaxStop(function () {
          $(function () {
            $( '#EventTable' ).searchable({
                searchType: 'default'
            });
        });
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
