<?php
include "db_connection.php";
include "functions.php";

session_start();

//Eingaben der Inputfelder auslesen
$s_title = $_POST["s_title"];
$s_token = $_POST["s_token"];
$number_of_questions = $_POST["number_of_questions"];

//vor Injection schützen
$s_title = $db->real_escape_string($s_title);
$s_token = $db->real_escape_string($s_token);

//Prüfen, ob Titel bereits vergeben ist, indem eigene Funktion aufgerufen wird
if(!check_s_title($s_title, $db)){
echo "Der Titel ist bereits vergeben. <br>";
echo "<a href='create_survey.php'>Zurück zu: Fragebogen erstellen</a> <br>";

}else{

//Prüfen, ob Kürzel bereits vergeben ist, indem eigene Funktion aufgerufen wird
if(!check_s_token($s_token, $db)){
echo "Das Kürzel ist bereits vergeben.<br>";
echo "<a href='create_survey.php'>Zurück zu: Fragebogen erstellen</a> <br>";
}else{

//Prüfen, ob der Fragebogen mindestens einem Kurs zugewiesen ist
if(!isset($_POST['course'])){
echo "Bitte den Fragebogen für mindestens einen Kurs freischalten.<br>";
echo "<a href='create_survey.php'>Zurück zu: Fragebogen erstellen</a> <br>";
}else{

//Einfügen der Inputfelderdaten in die Tabelle Survey
if(!$db->query("insert into survey (s_token, s_title, username) values ('".$s_token."', '".$s_title."', 'username');")){
echo 'Fehler beim Ausführen des SQL Befehls';
}

//Einfügen der Information, für welche(n) Kurs(e) der Fragebogen freigeschaltet ist
foreach ($_POST['course'] as $c_token) {
    $db->query("insert into activation(c_token, s_token) values ('".$c_token."', '".$s_token."');");
}
echo  "<h1>Hier bitte die Fragen erfassen: </h1>";
//   Formular, um Fragen zu erfassen
//   Dynamische Erzeugung der Felder durch for Schleife
echo "<form action='send_questions.php' method='post'>";
      for($i=1; $i <= $number_of_questions; $i++){
      echo "<label for='text'>Frage $i </label> <br>
      <textarea id='text' name='questions[]' cols='50' rows='4' required></textarea> <br> <br>";
      }
      //Verstecktes Input, um Umfragenkürzel mit zu übergeben
      echo "<input type='hidden' value=".$s_token." name='s_token'/>";
      echo "<input type='submit' value='Fragen abschicken'/></form>";
}
}
}
?>

