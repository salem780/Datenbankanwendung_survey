<?php
include "db_connection.php";

//Prüfen, ob mindestens eine Frage ausgewählt wurde
if(!isset($_POST["question"])){
echo "Bitte mindestens eine Frage auswählen! <br>";
echo "<a href='delete_or_add_questions.php'> Zurück zu Fragebogen kopieren</a>";

}else{
$s_token = $_POST["s_token"];

foreach ($_POST["question"] as $id){
$db->query("delete from question where s_token='".$s_token."' and id = '".$id."';");
}

echo "Die Frage(n) wurde(n) erfolgreich gelöscht. <br>";
echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";
}
?>