<?php
//Author - Lea Buchhold
//Formular zum Löschen eines Fragebogens
//Durchführen des Löschens

include "session_surveyor.php";
include "db_connection.php";

//alle Fragebögen auslesen, die der User erstellt hat
$surveys = $db->query("select s_title from survey where username = '".$_SESSION['username']."';");

echo "<h1> Fragebogen löschen </h1>";
//Combobox zum Auswählen des zu löschenden Fragebogens
echo "<form method='POST'>";
echo "<select name='surveys'>";
while($row = mysqli_fetch_assoc($surveys)){
echo "<option>".$row["s_title"]."</option>";
}
echo "<input type='submit' value='Fragebogen löschen' name='submit_delete'>";
echo "</select></form>";
echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";

if(isset($_POST["submit_delete"])){

$selected_survey = $_POST['surveys'];

//Kürzel des ausgewählten Fragebogens selektieren
$s_token = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
$s_token = mysqli_fetch_assoc($s_token);
$s_token = $s_token["s_token"];

//Löschen des Fragebogens
$db->query("delete from survey where s_token = '".$s_token."';");

header("location:delete_survey.php");
}
?>