<?php
//Author - Lea Buchhold
//Verarbeiten des Formulars aus der Datei delete_or_add_questions.php (Je nach geklickten Button Hinzufügen oder Löschen von Fragen)
//Beim Löschen: Auswahl der Fragen des Fragebogens, sodass zu löschende Fragen angeklickt werden können
//Beim Hinzufügen: Abfrage, wie viele neue Fragen hinzugefügt werden sollen

include "session_surveyor.php";

//Zufriff durch Eingabe der Datei in der URL verhindern
if (!isset($_POST["submit_delete_questions"]) AND !isset($_POST["submit_add_questions"])) {
    echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a><br>";
	exit("So geht das aber nicht!");
}

include "db_connection.php";

$selected_survey = $_POST['surveys'];

//Kürzel des ausgewählten Fragebogens selektieren
$s_token = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
$s_token = mysqli_fetch_assoc($s_token);
$s_token = $s_token["s_token"];


//If Verzweigung, um zu testen, welcher Button geklickt wurde
if(isset($_POST["submit_delete_questions"])){

echo "Welche Frage(n) möchten Sie löschen? <br> <br>";

//Fragen auslesen
$questions = $db->query("select id, text from question where s_token = '".$s_token."';");

echo "<form method='POST' action='delete_questions.php'>";
//Dynamische Erzeugung von Checkboxen und Labels nach Anzahl der Fragen
while($row = mysqli_fetch_assoc($questions)){
echo "<label><input type='checkbox' name='question[]' value=".$row["id"].">"."Frage ".htmlentities($row["id"]).": ".htmlentities($row["text"])."</label> <br>";
 }
 //Verstecktes Inputfeld, um Umfragenkürzel mit zu übergeben
 echo "<input type='hidden' name='s_token' value=".$s_token.">";
 echo "<br> <input type='submit' name='submit_delete_questions' value='Frage(n) löschen'>";
 echo "</form>";


}else if(isset($_POST["submit_add_questions"])){
echo "Wie viele Fragen möchten Sie hinzufügen? <br> <br>";
echo "<form method='POST' action='add_questions.php'>";
echo "<input type='number' name='number_of_questions' min='1'>";
//Verstecktes Inputfeld, um Umfragenkürzel mit zu übergeben
echo "<input type='hidden' name='s_token' value=".$s_token.">";
echo "<input type='submit' value='Diese Anzahl Fragen hinzufügen' name='add_number_of_questions'>";
echo "</form>";


}
?>