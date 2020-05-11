
<?php
//Author:Alissa Templin
include "db_connection.php";
include 'session_student.php';
include 'functions.php';
$mnr = $_SESSION['mnr'];
//Name des Studenten ermitteln
$sql = $db->query("Select student_name from student WHERE mnr = '".$mnr."';");
$result = mysqli_fetch_assoc($sql);
$name = $result["student_name"];


?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fragebogen</title>
  </head>
  <body>
<form method="POST" action="rate_questions2.php">
   <?php

   echo "<h1>Hallo " . $name . "</h1>";
             if(check_mnr($db, $mnr)) {
             echo "<label>Wähle einen Fragebogen aus, den du bewerten möchtest:</label> <br><br>";
             while($row = mysqli_fetch_assoc($_SESSION['survey_active'])){
             echo "<label><input type='radio' name='survey' value=".$row['s_token'].">".$row['s_title']."</label> <br>";
             }


              } else{
              echo "Aktuell keine Fragebögen vorhanden!";}
   ?>

<br>
<button type="submit"
 <?php if (!check_mnr($db, $mnr)) echo "hidden"; ?>
 name="Submit">Beantworten</button></br>
</form>
<br>
<a href="logout.php">ausloggen</a>
  </body>
</html>