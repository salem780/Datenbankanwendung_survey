<?php
//Author - Lea Buchhold
//Verarbeitung der Informationen des Formulars der Datei create_survey.php (Einfügen des Titels, des Kürzels etc. in diverse Tabellen)
//Erzeugen eines Formulars, das das Erfassen der Fragen ermöglicht

include "session_surveyor.php";

//Cross-Site-Scripting verhindern
if (!isset($_POST["submit_survey"])) {
    echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a><br>";
	exit("So geht das aber nicht!");
}

include "db_connection.php";
include "functions.php";

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
if(!$db->query("insert into survey (s_token, s_title, username) values ('".$s_token."', '".$s_title."', '".$_SESSION['username']."');")){
echo 'Fehler beim Ausführen des SQL Befehls';
}

//Einfügen der Information, für welche(n) Kurs(e) der Fragebogen freigeschaltet ist
//Auslesen der freigeschalteten Studenten und Einfügen der Statusinformation für die freigeschalteten Studenten
foreach ($_POST['course'] as $c_token) {
    $db->query("insert into activation(c_token, s_token) values ('".$c_token."', '".$s_token."');");
    $result = $db->query("select MNR from student where c_token = '".$c_token."';");
    while($row = mysqli_fetch_assoc($result)){
    $db->query("insert into answered (MNR, s_token, status) values ('".$row["MNR"]."', '".$s_token."', 0);");
    }
}

//   Formular, um Fragen zu erfassen
echo  "<h1>Hier bitte die Fragen erfassen: </h1>";
echo "<form action='send_questions.php' method='post'>";
//    Dynamische Erzeugung der Felder durch eine for Schleife
      for($i=1; $i <= $number_of_questions; $i++){
      echo "<label for='text'>Frage $i </label> <br>
      <textarea id='text' name='questions[]' cols='50' rows='4' required></textarea> <br> <br>";
      }
      //Verstecktes Input, um Umfragenkürzel mit zu übergeben
      echo "<input type='hidden' value=".$s_token." name='s_token'/>";
      echo "<input type='submit' name='submit_questions' value='Fragen abschicken'/></form>";
}
}
}
?>

