<?php
include "db_connection.php";
session_start();


$id = 1;
foreach ($_POST['questions'] as $question) {
    if(!$db->query("insert into question(id, text, s_token) values ('".$id."', '".$question."', '".$_SESSION["s_token"]."');")){
    echo "Fehler beim Ausführen des SQL Befehls";
    }else{
 //   echo "springt rein";
    }
    $id++;
}

 $s_token = $_SESSION["s_token"];
 $s_title = $db->query("select s_title from survey where s_token = '".$s_token."'");
 $courses = $db->query("select c_token from activation where s_token = '".$s_token."'");
 $questions = $db->query("select text from question where s_token = '".$s_token."'");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datenbanken Survey</title>
  </head>
  <body>
    <h3>Die Erstellung des Fragebogens war erfolgreich </h3>
    <?php


    $s_title_row = $s_title->fetch_object();
    echo "Titel: " . $s_title_row->s_title . "<br>";

echo "Freigeschaltet für folgende Kurse: <br>";
while($row = mysqli_fetch_assoc($courses)) {
  echo $row["c_token"] . "<br>";
 }

echo "Fragen: <br>";
while($row = mysqli_fetch_assoc($questions)) {
  echo "Frage: " . $row["text"] . "<br>";
}

    ?>


    <a href="surveyor_logged.php"> Zurück zur Startseite</a>
  </body>
</html>
