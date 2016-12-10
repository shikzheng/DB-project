<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$_SESSION["createEvent_Title"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Title'], ENT_QUOTES));
$_SESSION["createEvent_Description"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Description'], ENT_QUOTES));
$_SESSION["createEvent_StartTime"] = $connection->real_escape_string(strip_tags($_POST['createEvent_StartTime'], ENT_QUOTES));
$_SESSION["createEvent_EndTime"] = $connection->real_escape_string(strip_tags($_POST['createEvent_EndTime'], ENT_QUOTES));
$_SESSION["createEvent_Location_Name"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Name'], ENT_QUOTES));
$_SESSION["createEvent_ZipCode"] = $connection->real_escape_string(strip_tags($_POST['createEvent_ZipCode'], ENT_QUOTES));


$_SESSION["createEvent_Location_Address"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Address'], ENT_QUOTES));
$_SESSION["createEvent_Location_Description"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Description'], ENT_QUOTES));
$_SESSION["createEvent_Location_Latitude"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Latitude'], ENT_QUOTES));
$_SESSION["createEvent_Location_Longitude"] = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Longitude'], ENT_QUOTES));


$createEvent_Title = $connection->real_escape_string(strip_tags($_POST['createEvent_Title'], ENT_QUOTES));
$createEvent_Description = $connection->real_escape_string(strip_tags($_POST['createEvent_Description'], ENT_QUOTES));
$createEvent_StartTime = $connection->real_escape_string(strip_tags($_POST['createEvent_StartTime'], ENT_QUOTES));
$createEvent_EndTime = $connection->real_escape_string(strip_tags($_POST['createEvent_EndTime'], ENT_QUOTES));
$createEvent_Location_Name = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Name'], ENT_QUOTES));
$createEvent_ZipCode = $connection->real_escape_string(strip_tags($_POST['createEvent_ZipCode'], ENT_QUOTES));

$createEvent_Location_Address = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Address'], ENT_QUOTES));
$createEvent_Location_Description = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Description'], ENT_QUOTES));
$createEvent_Location_Latitude = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Latitude'], ENT_QUOTES));
$createEvent_Location_Longitude = $connection->real_escape_string(strip_tags($_POST['createEvent_Location_Longitude'], ENT_QUOTES));



  if(strlen($createEvent_Title)>100){
      $_SESSION['createEventErrorMsg'] = "Title Name may not be more than 100 characters";
    } elseif(strlen($createEvent_Location_Name)>20){
      $_SESSION['createEventErrorMsg'] = "Location may not be more than 20 characters";
    } elseif(strlen($createEvent_Location_Address)>50){
      $_SESSION['createEventErrorMsg'] = "Location Address may not be more than 20 characters";
    } elseif(strlen($createEvent_Location_Latitude)>50){
      $_SESSION['createEventErrorMsg'] = "Location Latitude may not be more than 50 characters";
    } elseif(strlen($createEvent_Location_Longitude)>50){
      $_SESSION['createEventErrorMsg'] = "Location Longitude may not be more than 50 characters";
    } elseif(strlen($createEvent_ZipCode) != 5){
      $_SESSION['createEventErrorMsg'] = "Zip code must be 5 digits";
    } elseif(!ctype_digit($createEvent_ZipCode)){
      $_SESSION['createEventErrorMsg'] = "Only intergers are allowed for zip code";
    }else{
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['createEventErrorMsg'] = $connection->error;
        }
        if (!$connection->connect_errno) {
            $sql1 = "SELECT * FROM location WHERE location_name = '" . $createEvent_Location_Name . "' AND zipcode = '" . $createEvent_ZipCode . "';";
            $query_check_if_location_exist = $connection->query($sql1);
            if ($query_check_if_location_exist->num_rows == 0) {
              $sql2 = "INSERT INTO location (location_name, zipcode,address,description,latitude,longitude)
                      VALUES('" . $createEvent_Location_Name . "', '" . $createEvent_ZipCode . "', '" . $createEvent_Location_Address . "', '" . $createEvent_Location_Description . "', '" . $createEvent_Location_Latitude . "', '" . $createEvent_Location_Longitude . "');";
              $query_new_location_insert = $connection->query($sql2);
              if (!$query_new_location_insert) {
                printf("Errormessage: %s\n", $connection->error);
              }
            }
                $sql3 = "INSERT INTO an_event (title, description, start_time, end_time, location_name, zipcode)
                        VALUES('" . $createEvent_Title . "', '" . $createEvent_Description . "', '" . $createEvent_StartTime . "', '" . $createEvent_EndTime . "', '" . $createEvent_Location_Name . "', '" . $createEvent_ZipCode . "');";
                $query_new_event_insert = $connection->query($sql3);
                if (!$query_new_event_insert) {
                  printf("Errormessage: %s\n", $connection->error);
                }

                $event_id = $connection->insert_id;
                $sql4 = "INSERT INTO organize (event_id,group_id)
                        VALUES('" . $event_id . "', '" . $_SESSION['group_page_groupid'] . "');";
                $query_new_organize_insert = $connection->query($sql4);


                if ($query_new_event_insert) {
                    $_SESSION['createEventErrorMsg'] = "Success! The event has been created.";
                } else {
                    $_SESSION['createEventErrorMsg'] = "Event creation failed, please try again";
                }
        } else {
            $_SESSION['createEventErrorMsg'] = "Sorry, no database connection.";
        }
    }

  header("Location:groupPage.php");

?>
