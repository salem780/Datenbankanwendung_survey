<?php
//Author - Lea Buchhold
//Verarbeitung des Formulars der Datei processing_delete_or_add_questions.php (Löschen der ausgewählten Fragen)

include "session_surveyor.php";

//Zufriff durch Eingabe der Datei in der URL verhindern
if (!isset($_POST["submit_delete_questions"])) {
    echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a><br>";
	exit("So geht das aber nicht!");
}

include "db_connection.php";

//Prüfen, ob mindestens eine Frage ausgewählt wurde
if(!isset($_POST["question"])){
echo "Bitte mindestens eine Frage auswählen! <br>";
echo "<a href='delete_or_add_questions.php'> Zurück zu Fragen löschen oder kopieren</a>";

}else{
$s_token = $_POST["s_token"];

foreach ($_POST["question"] as $id){
$db->query("delete from question where s_token='".$s_token."' and id = '".$id."';");
//IDs der nachfolgenden Fragen updaten
$db->query("update question set id = id-1 where s_token='".$s_token."' and id > '".$id."';");
}

echo "Die Frage(n) wurde(n) erfolgreich gelöscht. <br>";
echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";
}
?>