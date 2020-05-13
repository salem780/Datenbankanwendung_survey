<?php
//Author - Lea Buchhold
//Formular, um einen erstellten Fragebogen für einen weiteren Kurs freizuschalten


include "session_surveyor.php";
include "db_connection.php";

//alle Fragebögen auslesen, die der User erstellt hat
$surveys = $db->query("select s_title from survey where username = '".$_SESSION['username']."';");

//Prüfen, ob ein Fragebogen erstellt wurde
if($surveys->num_rows == 0){
echo "Sie haben noch keinen Fragebogen erstellt!<br>";
echo "<a href='create_survey.php'>Einen Fragebogen erstellen</a><br>";
echo "<a href='surveyor_logged.php'>Zurück zur Startseite</a>";
exit;
}


echo "<h1> Fragebogen für Kurs freischalten </h1>";
//Combobox zum Auswählen des zu aktivierenden Fragebogens
echo "<form method='POST'>";
echo "<select name='surveys'>";
while($row = mysqli_fetch_assoc($surveys)){
echo "<option>".htmlentities($row["s_title"])."</option>";
}
echo "<input type='submit' value='Zur Kursauswahl' name='submit_survey'>";
echo "</select></form>";
echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";

    if(isset($_POST["submit_survey"])){

    $selected_survey = $_POST['surveys'];

    //Kürzel des ausgewählten Fragebogens selektieren
    $s_token = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
    $s_token = mysqli_fetch_assoc($s_token);
    $s_token = $s_token["s_token"];

    $courses = $db->query("select c_token from course where c_token not in (select c_token from activation where s_token = '".$s_token."');");
    //Prüfen, ob ein Kurs für den ausgewählte Fragebogen existiert, für den der Fragebogen noch nicht freigeschaltet wurde
    if($courses->num_rows == 0){
    echo "<br>Dieser Fragebogen ist bereits für alle Kurse freigeschaltet!<br>";
    exit;
    }

    echo "<br> Diesen Fragebogen: '".$selected_survey."' für einen der folgenden Kurse aktivieren: <br><br>";
    echo "<form method='POST' action='processing_activate_survey.php'>";
    echo "<select name='courses'>";
    while($row = mysqli_fetch_assoc($courses)){
    echo "<option>".htmlentities($row["c_token"])."</option>";
    }
    //Verstecktes Input, um Umfragenkürzel mit zu übergeben
    echo "<input type='hidden' value=".$s_token." name='s_token'/>";
    //Verstecktes Input, um Umfragenkürzel mit zu übergeben
    echo "<input type='hidden' value=".$selected_survey." name='s_title'/>";
    echo "<input type='submit' value='Fragebogen für Kurs aktivieren' name='submit_course'>";
    echo "</select></form>";
    }
?>