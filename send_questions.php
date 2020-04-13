<?php
include "db_connection.php";
session_start();

//Einfügen der Fragen in die Tabelle Question
$id = 1;
foreach ($_POST['questions'] as $question) {
    $question = $db->real_escape_string($question);
    $db->query("insert into question(id, text, s_token) values ('".$id."', '".$question."', '".$_POST["s_token"]."');");
    $id++;
}

//Abfragen der eingegebenen Daten, um sie anzuzeigen
 $s_token = $_POST["s_token"];
 $s_title = $db->query("select s_title from survey where s_token = '".$s_token."';");
 $courses = $db->query("select c_token from activation where s_token = '".$s_token."';");
 $questions = $db->query("select id, text from question where s_token = '".$s_token."';");

echo  "<h3>Die Erstellung des Fragebogens war erfolgreich </h3>";

//Ausgeben der eingegebenen Daten
$s_title_row = mysqli_fetch_assoc($s_title);
echo "Titel: " . $s_title_row["s_title"] . "<br> <br>";

echo  "Kürzel: " . $s_token . "<br> <br>";

echo "Freigeschaltet für folgende Kurse: <br>";
while($row = mysqli_fetch_assoc($courses)) {
  echo $row["c_token"] . "<br>";
 }
echo "<br>";
echo "Fragen: <br>";
while($row = mysqli_fetch_assoc($questions)) {
  echo "Frage " . $row["id"] . ": " . $row["text"] . "<br>";
}
echo "<br>";
echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>"
    ?>



