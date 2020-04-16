<?php


include "session_surveyor.php";
include "db_connection.php";
include "functions.php";


if(isset($_POST["titlesearch"])){


$selected_survey = $_POST['surveytitles'];
 //$_SESSION["surveytitles"] = $selected_survey;
}




if(isset($_POST["coursesearch"])){

$selected_course = $_POST['coursetitles'];

 $_SESSION["coursetitles"] = $selected_course;
 //header("Location: rating.php");

}
?>
